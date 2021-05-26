<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class AjaxController extends Controller
{

    // 現在日時をタイムスタンプで返す
    public function currenttime_data()
    {
        // タイムスタンプ を取得
        $currenttime = new DateTime();
        $time = $currenttime->getTimestamp();
        // 配列形式に
        $data = ['nowtime' => $time];

        $json = json_encode($data);
        print($json);
    }

}
