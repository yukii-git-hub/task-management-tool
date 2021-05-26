@extends('layout')

@section('content')
<!-- 現在時刻 -->
@include('current-data-time/data-time')

<div class="main-project-create-wapper">

<!-- 新規プロジェクト名form -->
  <div class="new-project-title-create" id="new_project">
    <h2>新規プロジェクト名を入力してください</h2>
    <form id="new_project_form" methot="post" action="/project_create_name">
      @csrf
      <div class="project-title-create-wapper">
        <input type="text" class="project-title-create" name="project_title_create">
      </div>
      <div class="project-title-create-btn-wapper">
        <button type="submit" class="create-btn">作成する</button>
        <button class="back-btn"><a href="/project_list">キャンセル</a></button>
      </div>
    </form>
  </div>
  <div class=""></div>

   <h2 class="selecttime-plan-list"></h2>

<!-- 予定作成form -->
  <div class="list-create-wapper">
    <form id="project_plan_form" method="post" action="/project_create_plan">
      @csrf
      <input type="hidden" id="project_title_data" name="project_title" value="">
      <div class="setday-wapper">
        <spna class="setday-size">setDay:</spna> <input type="date" class="set-day-size" name="setday_data">
      </div>
      <div class="settime-wapper">
        <spna class="setTime-size">setTime:</spna> <input type="time" class="list-create-time" value="00:00" name="settime_data">
      </div>
      <input type="text" class="list-create-text" name="project_text_data" value="">
      <button type="submit" id="new_project_create_btn" class="list-create-submit">追加</button>
    </form>
  </div>

<!-- 予定一覧form -->
  <section>
    <form id="projectlist_post" class="project-create-confirm" method="post" action="/project_form_data">
      @csrf

      <div class="project-create-list-wapper">
        <ul id="project_show_list">
          <!-- jsでliを生成 -->
        </ul>
      </div>

      <button type="submit" class="project-registration" id="project_save">このプロジェクトを登録する</button>
    </form>
  </section>

</div>

@endsection

