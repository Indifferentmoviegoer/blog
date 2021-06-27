function getComments(item) {
    let result = document.createElement('div');
    result.innerHTML = '\
<div class="news-detail">\
<div class="container">\
<img src="/img/profile.jpeg" width="50px" alt="">\
<p>' + item.user_id + '</p>\
<p>' + item.text + '</p>\
<p>' + item.created_at + '</p>\
</div>\
</div>\
<br>';
    return result;
}

$(function () {
    $(".show-comment").on("click", function () {
        let news_id = $(this).data('news_id');
        let picture_id = $(this).data('picture_id');
        let length = document.getElementsByClassName("comment").length;
        $.ajax({
            url: '/comment/upload',
            type: 'POST',
            data: {news_id: news_id, picture_id: picture_id, length: length},
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
                alert('Комментариев не найдено!');
            }
        });

        return false;
    });
});