@extends('layout')


@section('content')
<!-- 現在時刻 -->
@include('current-data-time/data-time')

<div class="main-todolist-wapper">

  <div class="selecttime-plan-list">
    {{ $project_name }} [管理]
  </div>

  <div class="progress-graph">
    <div class="progress-graph-time-limit-wapper">
      <p>期間</p>
      <p class="time-limit">{{ $project_time_limit_first }} ~ {{ $project_time_limit_last }}</p>
      <p>現在日時から残り<span class="time-limit-day">{{ $project_time_limit }}</span>日</p>
    </div>

    <div class="progress-graph-meter">
      <p>進捗度</p>
      <meter max="100" min="0" value="{{ $project_percent }}"></meter>
      <p class="meter_number">
        {{ $project_done }}/{{ $project_number }} <span class="meter_number_percent">{{ $project_percent }}%</span>
      </p>
    </div>
  </div>

  <section>
    <div class="list-wapper project-list-wapper">
      <ul>
      @foreach($project_todolist as $listvalue)
        <li class="management-list <?php echo $clear_list = $listvalue->logic_delete == "0" ? "clear_project" : ""; ?>">
          <form class="projectlist_changeform" method="post" action="">
            @csrf
            <input type="hidden" name="select_project" value="{{ $listvalue->id }}">
            <input type="hidden" name="select_project_name" value="{{ $listvalue->project_name }}">
            <div class="setday-wapper">
              <spna class="setday-size">setDay:</spna>
              <input type="date" class="set-day-size" name="changeproject_select_time" value="{{ $listvalue->select_time }}">
            </div>
            <div class="settime-wapper">
              <spna class="setTime-size">setTime:</spna>
              <input type="time" class="list-create-time" value="{{ $listvalue->set_time }}" name="changeproject_settime">
            </div>
            <div class="list-text">
              <textarea class="project-management-change-text" name="changeproject_text">{{ $listvalue->task }}</textarea>
            </div>
            <div class="action-button">
              <!-- 初期値 -->
              <?php $logic_data = $listvalue->logic_delete ?>
              <button type="submit" class="update-project <?php echo $no_click = $logic_data == 0 ? "no_click" : ""; ?>" <?php echo $no_click = $logic_data == 0 ? "disabled" : ""; ?>>更新</button>
              <button type="submit" class="delete-project" data-status = "{{ $listvalue->logic_delete }}" data-selectid = "{{ $listvalue->id }}">
                <span class="change_btn">
                  @if ($logic_data == 1)
                    完了
                  @elseif ($logic_data == 0)
                    戻す
                  @endif
                </span>
              </button>
              <button type="submit" class="perfect_delete">削除</button>
            </div>
          </form>
        </li>
      @endforeach
      </ul>

    </div>
  </section>

</div>

@endsection