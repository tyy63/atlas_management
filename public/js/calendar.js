$(function () {
  $(function () {
    $('.open-modal-btn').on('click', function () {
      $('.js-modal').fadeIn();
      var reserveDate = $(this).attr('date');
      var reservePart = $(this).attr('part');
      $('#reserveDate').text(reserveDate);
      $('#reservePart').text(reservePart);

      $('#reserveDate').val(reserveDate);
      $('#reservePart').val(reservePart);

      return false;
    });

    $('.js-modal-close').on('click', function () {
      $('.js-modal').fadeOut();
      return false;
    });
  });
});
