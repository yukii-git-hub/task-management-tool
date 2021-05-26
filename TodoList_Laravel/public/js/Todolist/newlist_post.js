$(function() {

  // 追加ボタンを押したとき (新しいlist追加) post送信する
  $('#newlist_form').submit(function(event) {
    event.preventDefault();
    let $form = $(this);

    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: $form.attr('action'),
      type: 'POST',
      data: $form.serialize()
    }).done(function() {
      // ページリロード 該当する全てのデータをテーブルから引っ張るために
      location.reload();
    }).fail(function() {
      alert('入力されていません');
    });
  });

});