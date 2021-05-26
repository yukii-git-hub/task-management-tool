@extends('layout')

@section('content')
<!-- 現在時刻 -->
@include('current-data-time/data-time')

<div class="main-project-wapper">

  <div class="new-project-wapper">
    <h2>新規プロジェクト作成</h2>
    <div class="new-project-btn">
      <a href="/project_create">新規作成</a>
    </div>
  </div>

  <article class="project-list-wapper">
    <h2>現在参画中のプロジェクト</h2>
    <div class="project-list-scroll-wapper">
        <ul class="project-list">

        <!-- プロジェクト一覧を生成 -->
          {!! $projectlist !!}

        </ul>
      </div>
  </article>

</div>
@endsection