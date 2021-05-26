<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;

class ProjectListController extends Controller
{

    public function showProjectList()
    {
        // 現在選択されている日付 2021/02/10
        $projectlist = $this->_getProjectList();

        return view('project/project',[
            'projectlist' => $projectlist
        ]);
    }

    private function _getProjectList()
    {
        $todolist = new Todolist();
        $getProjectList = $todolist->ProjectList();
        return $getProjectList;
    }

}
