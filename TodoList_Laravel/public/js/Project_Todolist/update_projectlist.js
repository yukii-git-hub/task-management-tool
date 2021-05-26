$(function() {

  // 更新ボタンを押したとき (選択されたデータを更新する) post送信する
  $('.update-project').click(function() {
    $('.projectlist_changeform').attr('action', '/project_todolist_update');

    $('.projectlist_changeform').submit(function(event) {
      event.preventDefault();
      let $form = $(this);
    
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize()
      }).done(function() {
        alert('更新しました');
        // ページリロード データを昇順に並べ直すために
        location.reload();
      }).fail(function() {
        alert('error');
      });
    });
  });

});