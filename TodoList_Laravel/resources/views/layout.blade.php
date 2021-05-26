<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>タスク管理ツール</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>

  <header>
    @include('header')
  </header>

  <main>
    <section>
      @yield('content')
    </section>
  </main>

  <footer>
    @include('footer')
  </footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="{{ asset('/js/Time/currenttime.js') }}"></script>
  <script src="{{ asset('/js/mobile_menu.js') }}"></script>
  <script src="{{ asset('/js/Todolist/newlist_post.js') }}"></script>
  <script src="{{ asset('/js/Todolist/deletelist_post.js') }}"></script>
  <script src="{{ asset('/js/Todolist/updatelist_post.js') }}"></script>
  <script src="{{ asset('/js/Project/show_newcreate_post.js') }}"></script>
  <script src="{{ asset('/js/Project/project_createplan_post.js') }}"></script>
  <script src="{{ asset('/js/Project/projectlist_post.js') }}"></script>
  <script src="{{ asset('/js/Project_Todolist/update_projectlist.js') }}"></script>
  <script src="{{ asset('/js/Project_Todolist/perfect_delete_projectlist.js') }}"></script>
  <script src="{{ asset('/js/Project_Todolist/delete_projectlist.js') }}"></script>
</body>
</html>