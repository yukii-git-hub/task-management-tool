<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use App\Models\Calendar;
use DB;

class TodoListController extends Controller
{

    // TodoList 画面を表示する
    public function showTodoList()
    {
        // 現在選択されている日付 2021/02/10
        $selectday = $this->_getshowSelectData();
        // 現在選択されている日付 2021-02-10 post送信用
        $getSelectData = $this->_getSelectData();
        // 日付ごとの全listを表示する
        $showlist = $this->_getshowlist();

        return view('todolist-view/todolist',[
            'showlist' => $showlist,
            'getSelectData' => $getSelectData,
            'selectday' => $selectday,
        ]);
    }



    // 現在選択されている日付 をgetから取得 2021/02/10
    private function _getshowSelectData()
    {
        $todolist = new Todolist();
        $getshowSelectData = $todolist->showSelectData();
        return $getshowSelectData;
    }

    // 現在選択されている日付 をgetから取得 2021-02-10 post送信用 ※上記とは形式が違う
    private function _getSelectData()
    {
        $todolist = new Todolist();
        $getSelectData = $todolist->getSelectData();
        return $getSelectData;
    }

    // 日付ごとの全listを表示する
    private function _getshowlist()
    {
        $todolist = new Todolist;
        $showlist = $todolist->showlist();
        return $showlist;
    }

    //////////////////////////////////////////////////////////// ajax処理
    // Todolist[追加] ajaxでpostされたデータの受け取り
    public function _getNewPostData(Request $request)
    {
        $select_day = $request->select_day; // 表示されている日付を取得
        $settime_data = $request->settime_data; // セットされた時間
        $todolist_test_data = $request->todolist_text_data; // テキスト

        // DB操作
        DB::beginTransaction();

        try {
            $todolist = new Todolist();
            $todolist->select_time = $select_day;
            $todolist->set_time = $settime_data;
            $todolist->task = $todolist_test_data;
            $todolist->logic_delete = 1;
            $todolist->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    // Todolist[削除]
    public function _deleteData(Request $request)
    {
        $select_list_number_id = $request->list_number_id; // テーブルid 検索するid
        $change_list_select_day = $request->change_list_select_day; // 表示されている日付を取得
        $change_settime = $request->change_settime; // セットされた時間
        $change_text = $request->change_text; // テキスト

        $project_name_check = Todolist::where('id', $select_list_number_id)
                                        ->get();

        // プロジェクト名があるか存在チェック
        foreach ($project_name_check as $value) {
            $chack_project_name = $value->project_name;
        }

        // プロジェクト名があるTodolist の場合, 論理削除を行う 更新処理
        if (!empty($chack_project_name))
        {
            $logic_delete_query = Todolist::where('id', $select_list_number_id)->first();
            $logic_delete_query->logic_delete = "0";
            $logic_delete_query->save();
            return;
        }

        // DB操作
        DB::beginTransaction();

        try {
            $query = Todolist::query();
            $query->where('select_time', $change_list_select_day);
            $query->where('set_time', $change_settime);
            $query->where('task', $change_text);
            $query->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return;
    }

    // Todolist[更新]
    public function _update(Request $request)
    {
        $list_number_id = $request->list_number_id; // テーブルid 検索するid
        $change_settime = $request->change_settime; // 変更する時間
        $change_text = $request->change_text; // 変更するテキスト

        // DB操作
        DB::beginTransaction();

        try {
            $query = Todolist::where('id', $list_number_id)->first();
            $query->set_time = $change_settime;
            $query->task = $change_text;
            $query->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return;
    }
    //////////////////////////////////////////////////////////// ajax処理

}
