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
        index: index,
        picture_id: item.picture_id,
        name: item.name,
        desc: item.desc,
        published_at: item.published_at,
        category: item.text,
        category_id: item.forbidden,
        count: item.count_views,
    }
}

function getNews(i, res) {
    let result = document.createElement('div');
    result.innerHTML = '<button class="paginate-news" data-id="' + res + '" data-page="' + i + '">' + i + '</button>';

    return result;
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

                let templateNewsItem = document.getElementById('template-news-item').innerHTML,
                    compiled = _.template(templateNewsItem),
                    html = res.data.map(function (item, index) {
                        return compiled(getDataNews(item, index));
                    }).join('');
                $('#news-elements').append(html);


                let pagin = document.querySelectorAll('.paginate-news');
                pagin.forEach(function(elem){
                    elem.parentNode.removeChild(elem);
                });

                let list = document.getElementById('paginate-n');
                for (let i = 1; i <= res.data[0]['count_views']; i++) {
                    let div = getNews(i, res.data[0]['forbidden']);
                    list.append(div);
                }

            },
            error: function () {
                alert('Новостей не найдено!');
            }
        });

        return false;
    });
});

let pagination = document.querySelector('#paginate-n');

pagination.addEventListener('click', function(event){
    if(event.target && event.target.tagName === 'BUTTON'){

        let id = $(event.target).data('id');
        let page = $(event.target).data('page');
        $.ajax({
            url: '/v1/news/category',
            type: 'GET',
            data: {id: id, page:page},
            success: function (res) {
                if(res.error){
                    alert(res.error);
                    return;
                }

                let news = document.querySelectorAll('.news-items');
                news.forEach(function(elem){
                    elem.parentNode.removeChild(elem);
                });

                let templateProductItem = document.getElementById('template-news-item').innerHTML,
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
    }
    return false;
});

document.addEventListener("DOMContentLoaded", () => {
    $.ajax({
        url: '/v1/news/all-paginate',
        type: 'GET',
        success: function (res) {
            if(res.error){
                alert(res.error);
                return;
            }

            let news = document.querySelectorAll('.news-items');
            news.forEach(function(elem){
                elem.parentNode.removeChild(elem);
            });

            let templateNewsItem = document.getElementById('template-news-item').innerHTML,
                compiled = _.template(templateNewsItem),
                html = res.data.map(function(item, index) {
                    return compiled(getDataNews(item, index));
                }).join('');
            $('#news-elements').append(html);

            let list = document.getElementById('paginate-n');
            let pagin = document.querySelectorAll('.paginate-news');
            pagin.forEach(function(elem){
                elem.parentNode.removeChild(elem);
            });

            for (let i = 1; i <= res.data[0].count_views; i++) {
                let div = getNews(i, res.data[0].forbidden);
                list.append(div);
            }

        },
        error: function () {
            alert('Новостей не найдено!');
        }
    });
});

