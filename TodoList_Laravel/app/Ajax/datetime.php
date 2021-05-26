<?php

use DateTime;

// タイムスタンプ を取得
$currenttime = new DateTime();
$time = $currenttime->getTimestamp();

// 配列形式に
$data = ['time' => $time];
$json = json_encode($data);
print($json);