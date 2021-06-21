$('form').on('beforeSubmit', function () {
    let data;
    data = $(this).serialize();
    $.ajax({
        url: '/comment/create',
        type: 'POST',
        data: data,
        success: function () {
            alert('Комментарий успешно добавлен!');
            $.pjax.reload({container: "#commentPjax"});
        },
        error: function () {
            alert('Error!');
        }
    });

    return false;
});


function getComments(item) {
    let result = document.createElement('div');
    result.innerHTML = '\
<div style="background-color: white">\
<img src="/img/profile.jpeg" width="50px" alt="">\
<p>' + item.user_id + '</p>\
<p>' + item.text + '</p>\
<p>' + item.created_at + '</p>\
</div>\
<br>';
    return result;
}

const a = document.getElementById("button");
a.onclick = function () {
    let news_id = $(this).data('news_id');
    $.ajax({
        url: '/comment/upload',
        type: 'POST',
        data: {news_id: news_id},
        success: function (res) {
            const showComment = document.querySelector('.show-comment');
            if (showComment) {
                showComment.remove();
            }

            let list = document.getElementById('main');
            res.data.forEach(item => {
                let div = getComments(item);
                list.append(div);
            });
        },
        error: function () {
            alert('Error!');
        }
    });

    return false;
};

const dis = document.getElementById("dislike");
dis.onclick = function () {
    let picture_id = $(this).data('picture_id');
    $.ajax({
        url: '/gallery/dislike',
        type: 'POST',
        data: {picture_id: picture_id},
        success: function () {
            $.pjax.reload({container: "#galleryPjax"});
        },
        error: function () {
            alert('Error!');
        }
    });

    return false;
};

const like = document.getElementById("like");
like.onclick = function () {
    let picture_id = $(this).data('picture_id');
    $.ajax({
        url: '/gallery/like',
        type: 'POST',
        data: {picture_id: picture_id},
        success: function () {
            $.pjax.reload({container: "#galleryPjax"});
        },
        error: function () {
            alert('Error!');
        }
    });

    return false;
};