$(function() {
  // 新規プロジェクト作成画面

  // ページ表示時 新規プロジェクト名を入力だけを表示し,その他の画面をロックする
  $(window).on('load', function() {
    // url取得
    let url = location.href

    // 画面ロック
    if (url == "http://homestead.test/project_create") {
      $('.new-project-title-create').css('display', 'block');
      $("body").addClass("scroll-prevent");
    }
  });

  // 作成ボタンを押したら,画面ロックを解除, postで下のフォームに値を渡す
  $('#new_project_form').submit(function(event) {
    event.preventDefault();
    let $form = $(this);

    // プロジェクト名が入力されていなければダイアログを出す
    let $check_value = $('.project-title-create').val();
    if ($check_value == "") {
      alert("プロジェクト名を入力してください");
      return false;
    }

    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: $form.attr('action'),
      type: 'POST',
      data: $form.serialize(),
      dataType : "json"
    }).done(function(json) {
      let $data = json.projectname;
      $('#project_title_data').val($data);
      $('.selecttime-plan-list').text($data);
      $("body").removeClass("scroll-prevent");
      $('.new-project-title-create').css('display', 'none');
    }).fail(function() {
      alert('error');
    });
  });


});