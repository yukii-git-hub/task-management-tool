<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DatePeriod;
use DateTime;
use DateTimeZone;
use DateInterval;
use Exception;

class Calendar extends Model
{
    use HasFactory;

    public $_todayTime; // 現在日時取得
    public $_thisMonth; // [DateTimeインスタンス: セレクトされている年月]

    // コンストラクト
    public function __construct()
    {
        try {
        if (empty($_GET['value']) || !preg_match('/\A\d{4}-\d{2}\z/', $_GET['value'])) {
                throw new Exception();
            }
            $this->_thisMonth = new DateTime($_GET['value']);
        } catch (Exception $e) {
            $this->_thisMonth = new DateTime('first day of this month');
        }
        
        $this->_yearMonth = $this->_thisMonth->format('Y F');
        $this->showTime();
    }


    // 現在日時を取得 印をつける為に
    public function showTime()
    {
        $currenttime = new DateTime();
        $show_currenttime = $currenttime->setTimeZone(new DateTimeZone('Asia/Tokyo'))->format('Y-m-d');
        $this->_todayTime = $show_currenttime;
    }

    // カレンダー 年 月を表示する値を取得
    public function showyear()
    {
        $showyear = $this->_yearMonth;
        return $showyear;
    }

    // prev,nextボタンに渡す data_id [例 → 2021-01]
    public function data_id_code()
    {
        $show_this_manth = $this->_thisMonth;
        $select_data = $show_this_manth->format('Y-m');
        return $select_data;
    }

    // prev 先月に移動する
    public function PrevCalendar()
    {
        $data_clone = clone $this->_thisMonth;
        $prev = $data_clone->modify('-1 month')->format('Y-m');
        return $prev;
    }

    // next 来月に移動する
    public function NextCalendar()
    {
        $data_clone = clone $this->_thisMonth;
        $next = $data_clone->modify('+1 month')->format('Y-m');
        return $next;
    }
    
    
    // カレンダー [先月末 + 今月 + 来月始め] 表示
    public function create_ThisMonth_Calendar()
    {
        $show_ThisMonth_Calendar = '';
        $show_ThisMonth_Calendar .= $this->createLastCalendar();
        $show_ThisMonth_Calendar .= $this->createCalendar();
        $show_ThisMonth_Calendar .= $this->createNextCalendar();

        return $show_ThisMonth_Calendar;
    }


    // カレンダー 生成
    public function createCalendar()
    {
        $calendar_data = '';

        $period = new DatePeriod(
            new DateTime('first day of' . $this->_yearMonth),
            new DateInterval('P1D'),
            new DateTime('first day of' . $this->_yearMonth . '+1 month')
        );

        foreach ($period as $day) {

            if ($day->format('w') == 0) {
                $calendar_data .= sprintf('</tr><tr>');
            }

            if ($day->format('Y-m-d') == $this->_todayTime) {
                $calendar_data .= sprintf('<td><a href="/plans_todolist/?select=%d-%d-%d" class="today_mark class="youbi_%d"">%d</a></td>',
                 $day->format('Y'), $day->format('m'), $day->format('d'), $day->format('w'), $day->format('d'));
            } else {
                $calendar_data .= sprintf('<td><a href="/plans_todolist/?select=%d-%d-%d" class="youbi_%d">%d</a></td>',
                $day->format('Y'), $day->format('m'), $day->format('d'), $day->format('w'), $day->format('d'));
            }
        }
        return $calendar_data;
    }


    // 先月カレンダー 生成
    public function createLastCalendar()
    {
        $last_month_data = '';

        $last_calendar_data = new DateTime('last day of' . $this->_yearMonth . '-1 month');
        while ($last_calendar_data->format('w') < 6) {
            $last_month_data = sprintf('<td><a href="/plans_todolist/?select=%d-%d-%d" class="gray">%d</a></td>',
            $last_calendar_data->format('Y'), $last_calendar_data->format('m'), $last_calendar_data->format('d'), $last_calendar_data->format('d')) . $last_month_data;
            $last_calendar_data->sub(new DateInterval('P1D'));
        }
        return $last_month_data;
    }


    // 来月カレンダー 生成
    public function createNextCalendar()
    {
        $next_month_data = '';

        $next_calendar_data = new DateTime('first day of' . $this->_yearMonth . '+1 month');
        while ($next_calendar_data->format('w') > 0) {
            $next_month_data .= sprintf('<td><a href="/plans_todolist/?select=%d-%d-%d" class="gray">%d</a></td>',
            $next_calendar_data->format('Y'), $next_calendar_data->format('m'), $next_calendar_data->format('d'), $next_calendar_data->format('d'));
            $next_calendar_data->add(new DateInterval('P1D'));
        }
        return $next_month_data;
    }

}
