$(function () {
  $('.main_categories').click(function () {
    var category_id = $(this).attr('category_id');
    $('.category_num' + category_id).slideToggle();
  });


  $('.edit-modal-open').on('click', function () {
    $('.js-modal').fadeIn();
    var post_title = $(this).attr('post_title');
    var post_body = $(this).attr('post_body');
    var post_id = $(this).attr('post_id');
    $('.modal-inner-title input').val(post_title);
    $('.modal-inner-body textarea').text(post_body);
    $('.edit-modal-hidden').val(post_id);
    return false;
  });
  $('.js-modal-close').on('click', function () {
    $('.js-modal').fadeOut();
    return false;
  });

});


// like,unlike

$(document).on('click', '.like_btn', function (e) {
  e.preventDefault();
  var post_id = $(this).attr('post_id');
  var $likeCount = $('.like_counts' + post_id);
  var countInt = Number($likeCount.text());

  $(this).removeClass('like_btn').addClass('un_like_btn');
  $(this).find('i').removeClass('far').addClass('fas');

  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    method: "post",
    url: "/like/post/" + post_id,
    data: {
      post_id: post_id,
    },
  }).done(function (res) {
    console.log(res);
    $likeCount.text(countInt + 1);
  }).fail(function (res) {
    console.log('fail');
  });
});

$(document).on('click', '.un_like_btn', function (e) {
  e.preventDefault();
  var post_id = $(this).attr('post_id');
  var $likeCount = $('.like_counts' + post_id);
  var countInt = Number($likeCount.text());

  $(this).removeClass('un_like_btn').addClass('like_btn');
  $(this).find('i').removeClass('fas').addClass('far');

  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    method: "post",
    url: "/unlike/post/" + post_id,
    data: {
      post_id: post_id,
    },
  }).done(function (res) {
    $likeCount.text(countInt - 1);
  }).fail(function () {
    console.log('fail');
  });
});
