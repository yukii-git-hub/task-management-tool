<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;
use App\Models\ProjectManagementController;

class Todolist extends Model
{
    use HasFactory;
    protected $table = 'todolists';

    protected $fillable =
    [
        'set_time',
        'task'
    ];

    // 選択されている日時を取得する
    public function getSelectData()
    {
        $getSelectData = $_GET['select'];
        return $getSelectData;
    }

    // 選択されている日時を画面表示する 2021-02-10 を 2021/02/10 に変換
    public function showSelectData()
    {
       $WeekDays = ["(日)","(月)","(火)","(水)","(木)","(金)","(土)"];
       
       $getSelectData = $this->getSelectData(); // getで渡ってきた元のデータ
       $dateTime = new DateTime($getSelectData); // 曜日を取得するために
       $SelectWeek = $dateTime->format('w');

       $SelectData = explode("-", $getSelectData);
       $showSelectData = $SelectData[0].'/'.$SelectData[1].'/'.$SelectData[2].$WeekDays[$SelectWeek];
       return $showSelectData;
    }

    // 日付ごとの全listを取得する
    public function showlist()
    {
        $getSelectData = $this->getSelectData(); // getで渡ってきた元のデータ
        $list_data = Todolist::where('select_time', $getSelectData)
                                ->where('logic_delete', "1")
                                ->orderBy('set_time', 'asc')
                                ->get();
        return $list_data;
    }

    // プロジェクト一覧を取得する project_name
    public function ProjectList()
    {
        $projectlist = Todolist::select('project_name')->groupBy('project_name')->get();

        $show_projectlist = '';
        foreach ($projectlist as $value)
        {
            // プロジェクト名にデータがなければ,次のループに回す
            if (empty($value->project_name))
            {
                continue;
            }

            // プロジェクトlist の数
            $project_number = Todolist::where('project_name', $value->project_name)->count();
            // プロジェクトlist の 完了済みの数
            $project_done = Todolist::where('project_name', $value->project_name)
                                        ->where('logic_delete', "0")
                                        ->count();
            // %表示変換
            $project_completeness_value = $project_done / $project_number * 100;
            $project_completeness = round($project_completeness_value);

            $show_projectlist .=
                '<li>'.
                    '<h3 class="project-title">'.
                        '<a href="/project_management/?projectname_value='. $value->project_name .'">'. $value->project_name .'</a>'.
                    '</h3>'.
                    '<div class="project-gauge-wapper">'.
                        '<span class="project-gauge-tag">進捗 :</span>'.
                        '<div class="project-gauge"><meter max="100" min="0" value="'. $project_completeness .'"></meter></div>'.
                        '<span class="gauge-percent">'. $project_completeness .'%</span>'.
                        '<span class="gauge-percent_number">'. $project_done .'/'. $project_number .'</span>'.
                    '</div>'.
                '</li>';
        }
        return $show_projectlist;
    }

    // プロジェクト一覧を取得 home画面に渡し 表示
    public function HomeProjectList()
    {
        $projectlist = Todolist::select('project_name')->groupBy('project_name')->get();
        
        $home_show_project = '';
        foreach ($projectlist as $value)
        {
            // プロジェクト名にデータがなければ,次のループに回す
            if (empty($value->project_name))
            {
                continue;
            }
            
            $home_show_project .=
            '<li><h3><a href="/project_management/?projectname_value='. $value->project_name .'">'. $value->project_name .'</a></h3></li>';
        }
        return $home_show_project;
    }

    // 指定されたプロジェクト Todolist 一覧を表示 固有プロジェクト画面に渡す
    public function getProjectListAll(string $select_project)
    {
        // DBから指定されたプロジェクト内のTodolistをサーチ
        $get_projectlist_data = Todolist::where('project_name', $select_project)
                                        ->orderBy('select_time', 'asc')
                                        ->orderBy('set_time', 'asc')
                                        ->get();

        foreach ($get_projectlist_data as $value)
        {
            // settime 2021-3-13 を 2021-03-13 に表示変更する ,左から6番目の文字が1意外なら0を追加する
            $cheack_value = substr($value->select_time, 5, 1); // 左から6番目の文字を取得
            
            $project_settime = $value->select_time; // 表示変更前のタイムデータを格納する
            if ($cheack_value !== 1)
            {
                $value->select_time = substr_replace($project_settime, '0', 5, 0);
            }
        }
        return $get_projectlist_data;
    }

}
