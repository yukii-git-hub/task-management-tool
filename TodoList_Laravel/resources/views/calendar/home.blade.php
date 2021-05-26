@extends('layout')

<!-- カレンダー表示 -->
@section('content')
<!-- 現在時刻 -->
@include('current-data-time/data-time')

<div class="main-wapper">
  <table class="calender-table">
    <thead>
      <tr class="select-year">
        <th colspan="7">{!! $showyearmonth !!}</th>
      </tr>

      <tr class="week-tr">
        <th>日</th>
        <th>月</th>
        <th>火</th>
        <th>水</th>
        <th>木</th>
        <th>金</th>
        <th>土</th>
      </tr>
    </thead>

    <tbody>
        {!! $showCalendar !!}
    </tbody>

    <tfoot>
      <tr>
        <td class="last-month change-button"><a href="/get_request/?value={{ $prev_data }}">&laquo;</a></td>
        <td colspan="5" class="today-return change-button"><a href="/">Today</a></td>
        <td class="next-month change-button"><a href="/get_request/?value={{ $next_data }}">&raquo;</a></td>
      </tr>
    </tfoot>
  </table>

  <article>
    <h2 class="plan-project">現在参画中のプロジェクト</h2>
    <div class="plan-project-wapper">
        <ul class="plan-project-list">

          <!-- プロジェクト名 一覧表示 -->
          {!! $show_projectlist !!}
          
        </ul>
      </div>
    </div>
  </article>

</div>
@endsection