<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Calendar; // カレンダーclass
use App\Models\Todolist; // プロジェクト関連class

class HomeController extends Controller
{

    //ホーム画面に飛ぶ
    public function showHome()
    {
        // カレンダーの年月を表示する
        $showyearmonth = $this->_getyearmonth();
        // カレンダーを表示する
        $showCalendar = $this->_getcreate_ThisMonth_Calendar();
        // prev
        $prev_data = $this->_getPrevCalendar();
        // next
        $next_data = $this->_getNextCalendar();
        // プロジェクト一覧表示
        $show_projectlist = $this->_getProjectListName();

        return view('calendar/home', [
            'showyearmonth' => $showyearmonth,
            'showCalendar' => $showCalendar,
            'prev_data' => $prev_data,
            'next_data' => $next_data,
            'show_projectlist' => $show_projectlist,
            ]);
    }


    // カレンダーの year を表示する
    private function _getyearmonth()
    {
        $calendar = new Calendar();
        $showyearmonth = $calendar->showyear();
        return $showyearmonth;
    }

    // カレンダーを表示する
    private function _getcreate_ThisMonth_Calendar()
    {
        $calendar = new Calendar();
        $showCalendar = $calendar->create_ThisMonth_Calendar();
        return $showCalendar;
    }

    // 先月に切り替える
    private function _getPrevCalendar()
    {
        $calendar = new Calendar();
        $prev_change = $calendar->PrevCalendar();
        return $prev_change;
    }

    // 来月に切り替える
    private function _getNextCalendar()
    {
        $calendar = new Calendar();
        $next_change = $calendar->NextCalendar();
        return $next_change;
    }

    // プロジェクト名 一覧を表示する
    private function _getProjectListName()
    {
        $todolist = new Todolist();
        $show_project = $todolist->HomeProjectList();
        return $show_project;
    }

}
