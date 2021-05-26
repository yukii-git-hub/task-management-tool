$(function() {

  // 削除ボタンを押したとき (選択されたデータを削除する) post送信する
  $('.perfect_delete').click(function() {
    $('.projectlist_changeform').attr('action', '/project_todolist_perfect_delete');

    $('.projectlist_changeform').submit(function(event) {
      $(this).parents('li').fadeOut(500);
      event.preventDefault();
      let $form = $(this);
    

      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize(),
        dataType: 'json',
      }).done(function(data) {

        // プロジェクト件数が 0 の時, プロジェクト一覧画面にリダイレクトさせる
        let $project_residue = data.project_residue; // プロジェクトリスト残量
        
        if ($project_residue == 0) {
          window.location.href = '/project_list';
        }

      }).fail(function() {
        alert('error');
      });
    });
  });

});