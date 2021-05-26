$(function() {
  let $count = 0; // name識別カウンター

  $('#project_plan_form').submit(function(event) {
    event.preventDefault();
    let $form = $(this);

    // 日付,テキストが入力されていなければダイアログを出す
    let $check_setday_value = $('.set-day-size').val();
    let $check_value = $('.list-create-text').val();
    if ($check_setday_value == "") {
      alert("日にちを入力してください");
      return false;
    } else if ($check_value == "") {
      alert("テキストを入力してください");
      return false;
    }


    $.ajax({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: $form.attr('action'),
      type: 'POST',
      data: $form.serialize(),
      dataType : "json"
    }).done(function(json) {

      $('#project_show_list').prepend(
        '<li>' +
          '<input type="hidden" name="project_name_' + $count + '" value="' + json.projectname + '">' +

          '<div class="setday-wapper">' +
            '<spna class="setday-size">setDay:</spna>' +
            '<input type="date" class="set-day-size" name="setday_data_' + $count + '" value="' + json.setday + '">' +
          '</div>' +

          '<div class="settime-wapper">' +
            '<spna class="setTime-size">setTime:</spna>' +
            '<input type="time" class="list-create-time" value="' + json.settime + '" name="settime_data_' + $count + '">' +
          '</div>' +

          '<div class="list-text">' +
            '<textarea class="project-create-change-text" name="change_text_' + $count + '">' + json.projecttext + '</textarea>' +
          '</div>' +
        '</li>'
        );

        $('#project_plan_form').find('.set-day-size').val("");
        $('#project_plan_form').find('.list-create-time').val("");
        $('#project_plan_form').find('.list-create-text').val("");
        $count++; // name識別カウンター
    }).fail(function() {
      alert('error');
    });

  });

});