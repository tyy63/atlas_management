$(function () {
  $('.subject_edit_btn').click(function () {
    var subjectInner = $(this).next('.subject_inner');
    subjectInner.slideToggle();
    $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
  });

  $('.search_user_btn').click(function () {
    $(this).next('.fas').toggleClass('fa-chevron-up fa-chevron-down');
    $(this).parent().next('.search_conditions_inner').slideToggle();
  });

  $('.main_categories').click(function () {
    $(this).find('.sub_categories').slideToggle();
    $(this).find('i').toggleClass('fa-chevron-up fa-chevron-down');
  });
});
