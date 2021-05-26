$(function() {

  // 更新ボタンを押したとき (選択されたデータを更新する) post送信する
  $('.update').click(function() {
    $('.change_list_form').attr('action', '/todolist_form_update');

    $('.change_list_form').submit(function(event) {
      event.preventDefault();
      let $form = $(this);
    
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize()
      }).done(function() {
        // ページリロード データを昇順に並べ直すために
        alert('更新しました');
        location.reload();
      }).fail(function() {
        alert('error');
      });
    });
  });

});