$(function() {

  // 完了ボタンを押したとき (選択されたデータを論理削除する) post送信する
  $('.delete-project').click(function() {
    $('.projectlist_changeform').attr('action', '/project_todolist_delete');

    // DBのid番号
    let $select_data = $(this).attr('data-selectid');
    // 論理値
    let $status = $(this).attr('data-status');
    // 押されたボタンを保持 doneの後に使用する
    let $this = $(this);

    $('.projectlist_changeform').submit(function(event) {
      $('.projectlist_changeform').off();
      event.preventDefault();
      let $form = $(this);
    
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: $form.attr('action'),
        type: 'POST',
        data: {
          'select_data' : $select_data,
          'status' : $status,
        },
        dataType: 'json',
        context: $this,
      }).done(function(data) {

        let $datastatus = data.data_status; // DBのデータから 論理値を取り出す

        if($datastatus == "0") {
          $($this).attr('data-status', "0");
          $($this).text('戻す');
          $($this).parents('.management-list').addClass('clear_project');
          $($this).prev('.update-project').prop('disabled', true); // 更新をクリック禁止にする
          $($this).prev('.update-project').addClass('no_click');
          $($this).prev('.update-project').removeClass('update-project');
    
        } else if($datastatus == "1") {
          $($this).attr('data-status', "1");
          $($this).text('完了');
          $($this).parents('.management-list').removeClass('clear_project');
          $($this).prev('.no_click').addClass('update-project');
          $($this).prev('.update-project').removeClass('no_click');
          $($this).prev('.update-project').prop('disabled', false);
        }

      }).fail(function() {
        alert('error');
      });
    });
  });

});