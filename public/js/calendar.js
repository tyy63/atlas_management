$(function () {
  $(function () {
    $('.open-modal-btn').on('click', function () {
      $('.js-modal').fadeIn();
      var reserveDate = $(this).data('date');
      var reservePart = $(this).data('part');
      $('.reserveDate').text(reserveDate);
      $('.reservePart').text(reservePart);


      $('.reserveDate').val(reserveDate);
      $('.reservePart').val(reservePart);

      return false;
    });

    // JS    モーダルのIDを変数化
    // $('.modal-input-post').val(post);
    // $('.modal-input-id').val(id);

    // bladeで受け取りをする
    // <input class="modal-input-id" type="hidden" name="post_id" value="">
    // <input class="modal-input-post" type="textarea" name="post" value=""></input>

    // コントローラのupdateメソッド内にinputで引き渡す  bladeの方でつけたname属性に対して（name="post_id"とname="post"）
    // public function postUpdate{
    // $Post_update = $request -> input('post');
    // $id = $request -> input('post_id');
    // }


    $('.js-modal-close').on('click', function () {
      $('.js-modal').fadeOut();
      return false;
    });
  });
});
