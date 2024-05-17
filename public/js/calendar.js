$(function () {
  $(function () {
    $('.open-modal-btn').on('click', function () {
      $('.js-modal').fadeIn();
      var reserveDate = $(this).data('date');
      var reservePart = $(this).data('part');
      $('#reserveDate').text(reserveDate);
      $('#reservePart').text(reservePart);
      return false;
    });

    $('.js-modal-close').on('click', function () {
      $('.js-modal').fadeOut();
      return false;
    });
  });
});
