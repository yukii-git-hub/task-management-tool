@extends('layout')


@section('content')
<!-- 現在時刻 -->
@include('current-data-time/data-time')

<div class="main-todolist-wapper">

  <div class="selecttime-plan-list">
   {{ $selectday }} の予定
  </div>

  <div class="list-create-wapper">
    <form id="newlist_form" method="post" action="/todolist_form_data">
      @csrf
      <input type="hidden" name="select_day" value="{{ $getSelectData }}">
      <spna class="setTime-size">setTime:</spna> <input type="time" class="list-create-time" value="00:00" name="settime_data"><br>
      <input type="text" class="list-create-text" name="todolist_text_data" value="">
      <button type="submit" id="newlist_btn" class="list-create-submit">追加</button>
    </form>
  </div>

  <section>
    <div class="list-wapper list-wapper-todo">
      <ul>
      <!-- カウンターid -->
      <?php $counter_id = 0; ?>
      @foreach($showlist as $listvalue)
        <li>
          <form class="change_list_form" method="post" action="">
            @csrf
            <input type="hidden" name="change_list_select_day" value="{{ $getSelectData }}">
            <input type="hidden" name="list_number_id" value="{{ $listvalue->id }}">
            <?php $showproject_name = !empty($listvalue->project_name) ? $listvalue->project_name : ""; ?>
            <?php echo '<span class="project_name">'. $showproject_name .'</span>' ?>
            <div class="list-time">
              <input type="time" class="change_time" value="{{ $listvalue->set_time }}" name="change_settime">
            </div>
            <div class="list-text">
              <textarea class="change_text" name="change_text">{{ $listvalue->task }}</textarea>
            </div>
            <div class="action-button">
              <button type="submit" class="update">更新</button>
              <button type="submit" class="delete">完了</button>
            </div>
          </form>
        </li>
      <?php $counter_id++; ?>
      @endforeach

      </ul>
    </div>
  </section>

</div>
@endsection