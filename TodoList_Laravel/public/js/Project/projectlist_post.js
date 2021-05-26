$(function() {

  // 新規プロジェクトリスト全てを保存する
  $('#projectlist_post').submit(function(event) {

    if (!confirm('この内容で、登録しますか..?')) {
      return false;
    } else {
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
      
      alert('投稿完了しました！');
      location.href = '/project_list';
    }
  });

});