$(function () {
  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
  });
});




$(function () {
  $('.subject_edit_btn').click(function () {
    $('.subject_inner').slideToggle();
    $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
  });

  $('.search_user_btn').click(function () {
    $(this).next('.fas').toggleClass('fa-chevron-up fa-chevron-down');
    $(this).parent().next('.search_conditions_inner').slideToggle();
  });
});



$(function () {
  $('.main_categories').click(function () {
    $(this).find('.sub_categories').slideToggle();
    $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
  });
});
