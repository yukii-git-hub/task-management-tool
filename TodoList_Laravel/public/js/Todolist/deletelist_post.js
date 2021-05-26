$(function() {

  // 削除ボタンを押したとき (選択されたデータを削除する) post送信する
  $('.delete').click(function() {
    $('.change_list_form').attr('action', '/todolist_form_delete');

    $('.change_list_form').submit(function(event) {
      $('.change_list_form').off();
      $(this).parents('li').fadeOut(500);
      event.preventDefault();
      let $form = $(this);
    
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize()
      }).done(function() {
      }).fail(function() {
        alert('error');
      });
    });
  });

});