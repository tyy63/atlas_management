<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }


// キャンセル用のメソッドを書く
public function delete(Request $request){

    $reserveDate = $request->input('date');
    $reservePart = $request->input('part');
    // dd($reservePart,$reserveDate);
    // 検索→変数化→1増やす,detachする
    $reserve_settings = ReserveSettings::where('setting_reserve', $reserveDate)
                                        ->where('setting_part', $reservePart)
                                        ->first();

    $reserve_settings->increment('limit_users');
    $reserve_settings->users()->detach(Auth::id());



    return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
}

    // try{
    //         dd($reserveDate,$reservePart);
    //     $getPart = $request->getPart;
    //     $getDate = $request->getData;
    //     if ($getDate && $getPart) {
    //     $reserveDays = array_filter(array_combine($getDate, $getPart));
    //     foreach($reserveDays as $key => $value){
    //         $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
    //         if($reserve_settings) {
    //             $reserve_settings->increment('limit_users');
    //             $reserve_settings->users()->detach(Auth::id());
    //         }
    //     }
    //     }
    //     DB::commit();
    // }catch(\Exception $e){
    //     DB::rollback();

    // }


}
