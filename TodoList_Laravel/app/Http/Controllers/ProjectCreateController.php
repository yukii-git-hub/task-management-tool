<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use DB;

class ProjectCreateController extends Controller
{
    public $_projectname;

    public function showProjectcreate()
    {
        return view('project/project-create');
    }

    //////////////////////////////////////////////////////////// ajax処理
    // 新規プロジェクト名を取得
    public function _getProjectCreateName(Request $request)
    {
        $ProjectName = $request->project_title_create;

        header("Content-type: application/json; charset=UTF-8");
        $data = ['projectname' => $ProjectName];
        $json = json_encode($data);
        return $json;
    }

    // 新規プロジェクトプランを取得
    public function _getProjectCreatePlan(Request $request)
    {
        $ProjectName = $request->project_title; // プロジェクト名
        $SetDay = $request->setday_data; // 日付
        $SetTime = $request->settime_data; // 時間
        $ProjectText = $request->project_text_data; // テキスト

        header("Content-type: application/json; charset=UTF-8");
        $data =
        [
            'projectname' => $ProjectName,
            'setday' => $SetDay,
            'settime' => $SetTime,
            'projecttext' => $ProjectText,
        ];

        $json = json_encode($data);
        return $json;
    }

    // 新規プロジェクトlist 全てデータ保存する
    public function _getProjectlistData(Request $request)
    {
        // project_name, setday_data, settime_data, change_text の４つのデータを保存する _0, _1 _2 とデータ番号が割り振られてくる

        // リクエスト 全てのデータを連想配列で取得
        $data = $request->all(); //送信された全てのデータ 配列

        $data_number = (count($data) -1) / 4; // データの数を知る
        $data_number = $data_number - 1; // 0スタートなので-1をする
        $data_count = $data_number; //ループ内で使う

        $token = array_shift($data); // 配列の一番目 tokenデータを移動
        $data_divide = array_chunk($data, 4); // 前から4つずつ別の配列に格納


        // トランザクション
        DB::beginTransaction();

        try {
            foreach ($data_divide as $divide_value)
            {
    
                $todolist = new Todolist();
                // 個々のtodoデータ配列をforeachで全て取り出す 保存する 0=>プロジェクト名, 1=>日付, 2=>時間, 3=>task
                foreach ($divide_value as $key => $todo_value)
                {
                    switch ($key) {
                        case 0: //プロジェクト名
                        $todolist->project_name = $todo_value;
                        break;
    
                        case 1: // 日付
                        // 形式を2021-01-05 から 2021-1-05 に変更し保存させる
    
                        $cheack_value = substr($todo_value, 5, 1); // 2021-01 月の0の位置を確認
                        if ($cheack_value  == 0)
                        {
                            $change_formation = substr_replace($todo_value, '', 5, 1);
                        }
    
                        $cheack_value_s = substr($change_formation, 7, 1); // 2021-01-05 日の0の位置を確認
                        if ($cheack_value_s == 0)
                        {
                            $change_formation = substr_replace($change_formation, '', 7, 1);
                        }
                        $todolist->select_time = $change_formation;
                        break;
    
                        case 2: // 時間
                        $todolist->set_time = $todo_value;
                        break;
    
                        case 3: //task データベースに保存
                        $todolist->task = $todo_value;
                        $todolist->logic_delete = 1;
                        $todolist->save();
                        break;
                    }
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

    }
    //////////////////////////////////////////////////////////// ajax処理
}
