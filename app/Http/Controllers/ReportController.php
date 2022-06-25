<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
        public function live()
    {
    $vessels_shipping = DB::table('vessels_log')
            ->select('*')
            ->where([['done', 0]])
            ->get();
    foreach ($vessels_shipping as $vessel) {
            $vessel->hours = 0;

            $qnt_sum = DB::table('loading')
            ->select(DB::raw('SUM(jumbo) as total_jumbo'), DB::raw('SUM(qnt) as total_qnt'),  DB::raw('count(*) as count'))
            ->where([['vessel_id', $vessel->vessel_id]])
            ->whereNotNull('qnt_date')
            ->first();
            if ($qnt_sum->total_jumbo == 0 ) $qnt_sum->total_jumbo='';
            else $qnt_sum->total_jumbo= ' ('. $qnt_sum->total_jumbo.')';

            $move_count = DB::table('move')
            ->select( DB::raw('count(*) as moves_count'))
            ->where([['vessel_id', $vessel->vessel_id] ,[ 'arrival' , '1']])
            ->first();
            $car_count = DB::table('cars')
            ->select('*')
            ->where([['vessel_id', $vessel->vessel_id],['done', 0]])
            ->count();

            $vessel->quantity = '('.number_format((float)$qnt_sum->total_qnt, 3, '.', '').')';
            $vessel->archive = '('. $qnt_sum->count.')';
            $vessel->phones = $qnt_sum->total_jumbo;
            $vessel->notes = $move_count->moves_count;
            $vessel->done = $car_count;

        if ($vessel->done == 0) {
            $now = Carbon::now();
        } else {
            $now = $vessel->end_date;
        }

        $arrival =   DB::table('arrival')
            ->select('*')
            ->where([['vessel_id', $vessel->vessel_id]])
            ->orderby('id', 'asc')
            ->first();

        if(isset($arrival->date)){
        $normal_date =strtotime($arrival->date);

        if($vessel->done == 1){
            $arrivals2 =   DB::table('arrival')
                ->select('*')
                ->where([['vessel_id', $vessel->vessel_id]])
                ->orderby('id', 'desc')
                ->first();

            $now = Carbon::parse($arrivals2->date);

        }else{
            $now = Carbon::now();
        }

        $normal_date0 = Carbon::parse($normal_date);
        $diff = $normal_date0->diff($now);

        $vessel->days = $diff->d *24;
        $vessel->hours = $diff->h + $vessel->days;

        }
      
        }

        

    $vessels_unloading = DB::table('unloading.vessels_log')
            ->select('*')
            ->where([['done', 0]])
            ->get();


        foreach ($vessels_unloading as $vessel) {
            $vessel->hours =0;

            $direct_moves = DB::table('unloading.move')
            ->select( DB::raw('count(*) as moves_count'))
            ->where([['vessel_id', $vessel->vessel_id] ,[ 'arrival' , '1'],[ 'move_type' , 'direct']])
            ->where('is_delete', '=', 0)
            ->first();

            $arrival_moves = DB::table('unloading.move')
            ->select( DB::raw('count(*) as moves_count'))
            ->where([['vessel_id', $vessel->vessel_id] ,[ 'arrival' , '1'],[ 'move_type' , 'normal']])
            ->where('is_delete', '=', 0)
            ->first();
            $car_count = DB::table('unloading.cars')
            ->select('*')
            ->where([['vessel_id', $vessel->vessel_id],['done', 0]])
            ->count();


            $vessel->direct_moves = $direct_moves->moves_count;
            $vessel->arrival_moves = $arrival_moves->moves_count;
            $vessel->car_count = $car_count;


    $direct_sum = DB::table('unloading.direct')
            ->select(DB::raw('SUM(jumbo) as jumbo'), DB::raw('count(*) as count'), DB::raw('SUM(qnt) as qnt'))
            ->where([['vessel_id', $vessel->vessel_id]])
            ->whereNotNull('qnt_date')
            ->where('is_delete', '=', 0)
            ->first();
    
    $normal_sum = DB::table('unloading.move')
        ->select(DB::raw('SUM(jumbo) as jumbo'), DB::raw('count(*) as count'), DB::raw('SUM(qnt) as qnt'))
        ->where([['vessel_id', $vessel->vessel_id] ,[ 'arrival' , '1'],[ 'move_type' , 'normal']])
        ->where('is_delete', '=', 0)
        ->first();

    

 $all_count = $direct_sum->count +   $normal_sum->count; 
 $all_qnt =   number_format($direct_sum->qnt +   $normal_sum->qnt, 3, '.', '');
 $all_jumbo = $direct_sum->jumbo +   $normal_sum->jumbo;

 $vessel->all_count = $all_count;
 $vessel->all_qnt = $all_qnt;
 $vessel->all_jumbo = $all_jumbo;
 
 //times

        if ($vessel->done == 0) {
            $now = Carbon::now();
        } else {
            $now = $vessel->end_date;
        }

           $arrival = DB::table('unloading.move')
            ->select('*')
            ->where([['vessel_id', $vessel->vessel_id],['arrival', 1]])
            ->where('is_delete', '=', 0)
            ->orderby('arrival_date', 'asc')
            ->get()->first();
            
 if(isset($arrival->arrival_date)){
        $normal_date =strtotime($arrival->arrival_date);

        if($vessel->done == 1){
            $arrivals2 =   DB::table('unloading.move')
                ->select('*')
                ->where([['vessel_id', $vessel->vessel_id],['arrival', 1]])
                ->where('is_delete', '=', 0)
                ->orderby('arrival_date', 'desc')
                ->first();

            $now = Carbon::parse($arrivals2->arrival_date);

        }else{
            $now = Carbon::now();
        }

        $normal_date0 = Carbon::parse($normal_date);
        $diff = $normal_date0->diff($now);

        $vessel->days = $diff->d *24;
        $vessel->hours = $diff->h + $vessel->days;

        }

        }


$vessels = $vessels_shipping->merge($vessels_unloading); // Contains foo and bar.
    return view('reports.live2', [
            'vessels' => $vessels,
    ]);
    }
}
