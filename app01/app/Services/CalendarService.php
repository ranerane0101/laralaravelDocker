<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarService
{
    public function getWeeks()
    {
        $weeks = [];
        $week = '';

        $dt = new Carbon(self::getYm_firstday());
        $day_of_week = $dt->dayOfWeek;
        $days_in_month = $dt->daysInMonth;

        $week .= str_repeat('<td></td>', $day_of_week);

        for ($day = 1; $day <= $days_in_month; $day++, $day_of_week++){
            $date = self::getYm() . '-' . $day;
            if(Carbon::now()->format('Y-m-j') === $date){
                $week .= '<td class="today">' . $day;
            }else{
                $week .= '<td>' . $day;
            }
            $week .= '</td>';

            if(($day_of_week % 7 ===6) || ($day === $days_in_month)){
                if($day === $days_in_month){
                    $week .= str_repeat('<td></td>', 6 - ($day_of_week % 7));
                }
                $weeks[] = '<tr>' . $week . '</tr>';
                $week = '';
            }
        }
        return $weeks;
    }
public function  getMonth()
{
    return Carbon::parse(self::getYm_firstday())->format('Y年n月');
}

public function getPrev()
{
    return Carbon::parse(self::getYm_firstday())->subMonthsNoOverflow()->format('Y-m');
}
public function getNext()
{
return Carbon::parse(self::getYm_firstday())->addMonthNoOverflow()->format('Y-m');
}

private static function getYm()
{
    if(isset($_GET['ym'])){
        return $_GET['ym'];
    }
    return Carbon::now()->format('Y-m');
}

private static function getYm_firstday()
{
    return self::getYm() . '-01';
}
}