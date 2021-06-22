function getComments(item) {
    let result = document.createElement('div');
    result.innerHTML = '\
<div class="comment" style="background-color: white">\
<img src="/img/profile.jpeg" width="50px" alt="">\
<p>' + item.user_id + '</p>\
<p>' + item.text + '</p>\
<p>' + item.created_at + '</p>\
</div>\
<br>';
    return result;
}

// const a = document.getElementById("button");
//
// if(a){
//     a.addEventListener('click', function() {
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


// const dis = document.getElementById("dislike");
// const dis = document.querySelector('.dislike');
//
// if(dis) {
//     dis.addEventListener('click', function () {
$(function () {
    $(".dislike").on("click", function () {
        let picture_id = $(this).data('picture_id');
        $.ajax({
            url: '/gallery/dislike',
            type: 'POST',
            data: {picture_id: picture_id},
            success: function () {
                $.pjax.reload({container: "#galleryPjax-"+picture_id});
            },
            error: function () {
                alert('Авторизуйтесь для оценки изображения!');
            }
        });

        return false;
    });
});

// const like = document.getElementById("like");

// const like = document.querySelector('.like');
//
// if(like) {
//     like.addEventListener('click', function () {
$(function () {
    $(".like").on("click", function () {
        let picture_id = $(this).data('picture_id');
        $.ajax({
            url: '/gallery/like',
            type: 'POST',
            data: {picture_id: picture_id},
            success: function () {
                // let number = document.getElementById("count").textContent;
                // document.getElementById("count").innerHTML = number + 1;
                $.pjax.reload({container: "#galleryPjax-"+picture_id});
            },
            error: function () {
                alert('Авторизуйтесь для оценки изображения!');
            }
        });

        return false;
    });
});