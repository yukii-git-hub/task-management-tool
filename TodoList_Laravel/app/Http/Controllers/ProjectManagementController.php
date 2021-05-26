<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use DateTime;
use DB;

class ProjectManagementController extends Controller
{

    // 表示するproject名を受け取る
    private $_project_name_value = "";
    // プロジェクト内容数
    private $_project_number = "";
    // プロジェクト 完了数 [済]
    private $_project_done = "";
    // プロジェクト 期間 最小値
    private $_project_time_limit_first = "";
    // プロジェクト 期間 最大値
    private $_project_time_limit_last = "";

    // プロジェクト管理画面を表示する
    public function showProjectManagement()
    {
        // 固有プロジェクト Todolist一覧
        $project_todolist = $this->showProjectListAll();
        // 期間
        $project_time_limit = $this->_getTimeCountdown();
        // クリア済 projectlist パーセンテージ
        $project_percent = $this->_getManagementData();

        return view('project/project-management',[
            'project_todolist' => $project_todolist,
            'project_name' => $this->_project_name_value,
            'project_time_limit_first' => $this->_project_time_limit_first,
            'project_time_limit_last' => $this->_project_time_limit_last,
            'project_time_limit' => $project_time_limit,
            'project_number' => $this->_project_number,
            'project_done' => $this->_project_done,
            'project_percent' => $project_percent,
        ]);
    }
    
    // プロジェクト Todolist 一覧表示
    private function showProjectListAll()
    {
        // プロジェクト名が格納される
        $projectname = $this->_project_name_value;

        $todolist = new Todolist();
        $project_todolist = $todolist->getProjectListAll($projectname);
        return $project_todolist;
    }

    // homeからクリックされた project名を getで受けて todolist@getProjectListAll() に渡す
    public function _getselect_project_name(Request $request)
    {
        $project_name_value = $request->input('projectname_value');
        $this->_project_name_value = $project_name_value;

        // view に渡す
        return $this->showProjectManagement();
    }

    // プロジェクト管理画面 データをviewに渡す
    private function _getManagementData()
    {
        // プロジェクトlist の数
        $this->_project_number = Todolist::where('project_name', $this->_project_name_value)->count();

        // プロジェクトlist の 完了済みの数
        $this->_project_done = Todolist::where('project_name', $this->_project_name_value)
        ->where('logic_delete', "0")
        ->count();

        // %表示変換
        $project_completeness_value = $this->_project_done / $this->_project_number * 100;
        $project_completeness = round($project_completeness_value);

        return $project_completeness;
    }

    // 現在日からプロジェクトの最終日 の日数をviewに渡す
    private function _getTimeCountdown()
    {
        // 最小値 期間
        $this->_project_time_limit_first = Todolist::where('project_name', $this->_project_name_value)
                                                    ->min('select_time');

        // 最大値 期間
        $this->_project_time_limit_last = Todolist::where('project_name', $this->_project_name_value)
                                                    ->max('select_time');

        $cheack_value = substr($this->_project_time_limit_last, 5, 1); // 左から6番目の文字を取得, 2021-7-15 を 2021-07-15 に変更
        $project_limit_last_format = $this->_project_time_limit_last;

        if ($cheack_value !== 1)
        {
            $project_limit_last_format = substr_replace($project_limit_last_format, '0', 5, 0);
        }
        
        // 現在時間
        $current_time = new DateTime('now');
        // 指定した日付
        $set_time = new DateTime($project_limit_last_format);

        $diff = $current_time->diff($set_time);
        $limit_day = $diff->days;
        $limit_day += 1;
        return $limit_day;
    }

    //////////////////////////////////////////////////////////// ajax処理
    // Todolist project [更新]
    public function _update_project(Request $request)
    {
        $select_project_number_id = $request->select_project; // テーブルid 検索するid
        $change_settime = $request->changeproject_settime; // 変更する時間
        $change_text = $request->changeproject_text; // 変更するテキスト

        // DB操作
        DB::beginTransaction();

        try {
            $change_select_time = $request->changeproject_select_time; // 変更する日時 2021-03-30 の0を消して保存する
            $cheack_value = substr($change_select_time, 5, 1); // 左から6番目の文字を取得
            if ($cheack_value !== 1)
            {
                $change_select_time = substr_replace($change_select_time, '', 5, 1);
            }
    
            $query = Todolist::where('id', $select_project_number_id)->first();
            $query->select_time = $change_select_time;
            $query->set_time = $change_settime;
            $query->task = $change_text;
            $query->save();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return;
    }

    // Todolist[完全削除]
    public function _perfect_delete_project(Request $request)
    {
        $select_project_number_id = $request->select_project; // テーブルid 検索するid
        $change_settime = $request->changeproject_settime; // セットされている時間
        $change_text = $request->changeproject_text; // セットされているテキスト
        $select_project_name = $request->select_project_name; // 選択されているプロジェクト名

        // DB操作
        DB::beginTransaction();

        try {
            $change_select_time = $request->changeproject_select_time; // セットされている日時 2021-03-30 の0を消して保存する
            $cheack_value = substr($change_select_time, 5, 1); // 左から6番目の文字を取得
            if ($cheack_value !== 1)
            {
                $change_select_time = substr_replace($change_select_time, '', 5, 1);
            }
    
            $query = Todolist::query();
            $query->where('id', $select_project_number_id);
            $query->where('select_time', $change_select_time);
            $query->where('set_time', $change_settime);
            $query->where('task', $change_text);
            $query->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        // プロジェクト件数が 0 の時, プロジェクト一覧画面にリダイレクトさせる jsに渡す
        // プロジェクト リスト数を取得
        $project_residue = Todolist::where('project_name', $select_project_name)
                                ->count();

        header("Content-type: application/json; charset=UTF-8");
        $data = ['project_residue' => $project_residue];
        $json = json_encode($data);
        return $json;
    }

    // Todolist[論理削除]
    public function _delete_project(Request $request)
    {
        $select_project_number_id = $_POST['select_data']; // テーブルid 検索するid
        $data_status = $_POST['status']; // 論理削除データ 1 or 0

        if ($data_status == "0")
        {
            $data_status = "1";
        } elseif ($data_status == "1")
        {
            $data_status = "0";
        };

        // DB操作
        DB::beginTransaction();

        try {
            $data = ['data_status' => $data_status];
            $json = json_encode($data);
            print($json);
    
            $query = Todolist::where('id', $select_project_number_id)->first();
            $query->logic_delete = $data_status;
            $query->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return;
    }
    //////////////////////////////////////////////////////////// ajax処理
    
}
