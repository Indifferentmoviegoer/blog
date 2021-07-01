document.addEventListener("DOMContentLoaded", () => {
    let list = document.querySelectorAll('.comment-item').length;

    if(list < 20){
        document.querySelector('.show-comment').hidden=true;
    } else if(list === 20) {
        document.querySelector('.show-comment').hidden=false;
    }
});

function getComments(item) {
    let result = document.createElement('div');

    result.innerHTML = '\
        <div class="news-detail">\
            <div class="container">\
                <div class="comment">\
                    <img src="/img/profile.jpeg" width="50px" alt="">\
                    <p>' + item.user_id + '</p>\
                    <p>' + item.text + '</p>\
                    <p>' + item.created_at + '</p>\
                </div>\
            </div>\
        </div>\
        <br>';

    return result;
}

$('#commentForm').on('beforeSubmit', function () {
    let data;
    data = $(this).serialize();
    $.ajax({
        url: '/v1/comment/create',
        type: 'POST',
        data: data,
        success: function (res) {
            if (!res.moderation) {
                alert('Комментарий отправлен на премодерацию!');
            } else {
                let list = document.getElementById('new-comment');
                let div = getComments(res.data);
                list.prepend(div);
                alert('Комментарий успешно добавлен!');
            }

            document.getElementById('text-comment').value = '';
        },
        error: function () {
            alert('Произошла ошибка при добавлении комментария!');
        }
    });

    return false;
});

$(function () {
    $(".show-comment").on("click", function () {
        let news_id = $(this).data('news_id');
        let picture_id = $(this).data('picture_id');
        let length = document.querySelectorAll('.comment').length;
        $.ajax({
            url: '/v1/comment/upload',
            type: 'POST',
            data: {news_id: news_id, picture_id: picture_id, length: length},
            success: function (res) {
                if(res.error){
                    alert(res.error);
                    return;
                }
                const showComment = document.querySelector('.show-comment');
                if (showComment) {
                    showComment.remove();
                }

                let list = document.getElementById('more-comment');
                res.data.forEach(item => {
                    let div = getComments(item);
                    list.append(div);
                });
            },
            error: function () {
                alert('Комментариев не найдено!');
            }
        });

        return false;
    });
});

$(function() {
    $("#text-comment").keypress(function (e) {
        if(e.keyCode === 13) {
            $("#commentForm").submit();
            e.preventDefault();
        }

        if(e.ctrlKey && e.keyCode === 13){
            document.getElementById('text-comment').value += "\r\n";
        }
    });
});

function getDataNews(item, index) {
    return {
        id: item.id,
        i: index,
        picture_id: item.picture_id,
        name: item.name,
        desc: item.desc,
        published_at: item.published_at,
        category: item.text,
    }
}

$(function () {
    $(".category-item").on("click", function () {
        let id = $(this).data('id');
        $.ajax({
            url: '/v1/news/category',
            type: 'GET',
            data: {id: id},
            success: function (res) {
                if(res.error){
                    alert(res.error);
                    return;
                }

                let news = document.querySelectorAll('.news-items');

                news.forEach(function(elem){
                    elem.parentNode.removeChild(elem);
                });

                var templateProductItem = document.getElementById('template-product-item').innerHTML,
                    compiled = _.template(templateProductItem),
                    html = res.data.map(function(item, index) {
                        return compiled(getDataNews(item, index));
                    }).join('');

                $('#news-elements').append(html);

            },
            error: function () {
                alert('Новостей не найдено!');
            }
        });

        return false;
    });
});