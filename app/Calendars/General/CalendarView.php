<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<td class="calendar-td-past">';
        }else{
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();
        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
          }


// 過去日で予約してたら。最初のif
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'.$reservePart.'</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }

// 今日以降の予約に関してのelse　　
          else{
            if($reservePart =="リモ1部" ){
            $reservePart = 1;
          }else if($reservePart == "リモ2部"){
            $reservePart = 2;
          }else if($reservePart == "リモ3部"){
            $reservePart = 3;
          }

            $html[] = '<button type="button" class="btn btn-danger p-0 w-75 open-modal-btn" name="delete_date" style="font-size:12px" data-date="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'" data-part="'. $reservePart .'">'.'リモ'. $reservePart .'部'.'</button>';

            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
          // 受付終了表示　過去で予約していない時の記述
          }elseif(!in_array($day->everyDay(), $day->authReserveDay())&&$startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';



          }
          // 未来分で予約していない時。（通常の今日以降の予約が選択できる状態）
          else{
          $html[] = $day->selectPart($day->everyDay());
          }

        $html[] = $day->getDate();
        $html[] = '</td>';
        }
        $html[] = '</tr>';
        }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }
  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
