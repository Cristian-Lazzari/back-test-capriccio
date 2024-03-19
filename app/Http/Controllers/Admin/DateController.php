<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Date;
use App\Models\Order;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Database\Seeders\DatesTableSeeder;

class DateController extends Controller
{
    public function index()
    {
        $dates = Date::paginate(100);

        return view('admin.dates.index', compact('dates'));
    }


    public function updatestatus(Request $request)
    {
        $v = $request->input('v');
        $date = Date::find($request->input('id'));
        if($v == 1){
            $date->visible_fq = !$date->visible_fq;
            $date->save();
           
        }else if($v == 2){
            $date->visible_ft = !$date->visible_ft;
            $date->save();
           
        }else if($v == 3){
            $date->visible_t = !$date->visible_t;
            $date->save();
        }else if($v == 4){
            $date->visible_d = !$date->visible_d;
            $date->save();
        }
        
        return redirect()->back();
    }
   


    public function updateMax(Request $request)
    {
        $v = $request->input('v');
        $max = $request->input('max');
        $date = Date::find($request->input('id'));
    //  dd($max);
        if($v == 1){
            $date->max_res = $max;
        }else if($v == 2){
            $date->max_pz_t = $max;
        }else if($v == 3){
            $date->max_pz_q = $max;
        }else if($v == 4){
            $date->max_domicilio = $max;
        }
        $date->save();   
        return redirect()->back();
    }


    private $validations = [
        'max_domicilio'         => 'required|integer',
        'max_reservations'      => 'required|integer',
        'max_pz_q'              => 'required|integer',
        'max_pz_t'              => 'required|integer',
        'times_slot_1'          => 'array',
        'times_slot_1.*'        => 'string',
        'times_slot_2'          => 'array',
        'times_slot_2.*'        => 'string',
        'times_slot_3'          => 'array',
        'times_slot_3.*'        => 'string',
        'times_slot_4'          => 'array',
        'times_slot_4.*'        => 'string',
        'times_slot_5'          => 'array',
        'times_slot_5.*'        => 'string',
        'times_slot_6'          => 'array',
        'times_slot_6.*'        => 'string',
        'times_slot_7'          => 'array',
        'times_slot_7.*'        => 'string',
    ];

    public function runSeeder(Request $request)
    {
        try {
            $request->validate($this->validations);
            $max_reservations = $request->input("max_reservations");
            $max_pz_t = $request->input("max_pz_t");
            $max_pz_q = $request->input("max_pz_q");
            $max_domicilio = $request->input("max_domicilio");
            $days_off = $request->input("days_off");
            $times_slot1 = $request->input("times_slot_1");
            $times_slot2 = $request->input("times_slot_2");
            $times_slot3 = $request->input("times_slot_3");
            $times_slot4 = $request->input("times_slot_4");
            $times_slot5 = $request->input("times_slot_5");
            $times_slot6 = $request->input("times_slot_6");
            $times_slot7 = $request->input("times_slot_7");

            $timesDay = [
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                [
                    ['time' => '19:00', 'set' => ''] ,
                    ['time' => '19:15', 'set' => ''] ,
                    ['time' => '19:30', 'set' => ''] ,
                    ['time' => '19:45', 'set' => ''] ,
                    ['time' => '20:00', 'set' => ''] ,
                    ['time' => '20:15', 'set' => ''] ,
                    ['time' => '20:30', 'set' => ''] ,
                ],
                
   
            ];


            for ($i = 0; $i < count($timesDay[0]); $i++) {
                $timesDay[0][$i]['set'] = $times_slot1[$i];
            }
            for ($i = 0; $i < count($timesDay[1]); $i++) {
                $timesDay[1][$i]['set'] = $times_slot2[$i];
            }
            for ($i = 0; $i < count($timesDay[2]); $i++) {
                $timesDay[2][$i]['set'] = $times_slot3[$i];
            }
            for ($i = 0; $i < count($timesDay[3]); $i++) {
                $timesDay[3][$i]['set'] = $times_slot4[$i];
            }
            for ($i = 0; $i < count($timesDay[4]); $i++) {
                $timesDay[4][$i]['set'] = $times_slot5[$i];
            }
            for ($i = 0; $i < count($timesDay[5]); $i++) {
                $timesDay[5][$i]['set'] = $times_slot6[$i];
            }
            for ($i = 0; $i < count($timesDay[6]); $i++) {
                $timesDay[6][$i]['set'] = $times_slot7[$i];
            }

            //dd($timesDay);
            // @dd("max_reservations: " . $max_reservations, "times_slot: " . $timesDay_slot, "days_off: " . $days_off);
            // dump($timesDay);

            // Pulisco le tabelle
            DB::table('dates')->truncate();
            DB::table('months')->truncate();
            DB::table('days')->truncate();

            // Eseguo il seeder
            $seeder = new DatesTableSeeder();
            $seeder->setVariables($max_reservations, $max_pz_q, $max_pz_t, $timesDay, $days_off, $max_domicilio);
            $seeder->run();

            // Ripristino le prenotazioni
            $this->restoreReservationsAndOrders();

            return back()->with('success', 'Seeder avvenuto con successo')->with('response', [
                'success' => true,
                'message'  => 'Seeder avvenuto con successo',
            ]);
        } catch (Exception $e) {
            $trace = $e->getTrace();
            $errorInfo = [
                'success' => false,
                'error' => 'Si è verificato un errore durante l\'elaborazione della richiesta: ' . $e->getMessage(),
                'file' => $trace[0]['file'],
                'line' => $trace[0]['line'],
            ];

            return response()->json($errorInfo, 500);
        }
    }

    public function restoreReservationsAndOrders()
    {
        $reservations = Reservation::all();

        if ($reservations) {
            foreach ($reservations as $reservation) {
                $date = Date::where('date_slot', $reservation->date_slot)->first();
                if ($date) {
                    $date->reserved = $date->reserved + $reservation->n_person;
                    $date->save();
                }
            }
        }

        $orders = Order::all();

        if ($orders) {
            foreach ($orders as $order) {
                $date = Date::where('date_slot', $order->date_slot)->first();
                if ($date) {
                    $date->reserved_pz_q = $date->reserved_pz_q + $order->total_pz_q;
                    if($date->reserved_pz_q > $date->max_px_q){
                        $date->visble_fq = 0;
                    }
                    if($date->reserved_pz_t > $date->max_px_t){
                        $date->visble_ft = 0;
                    }
                    $date->save();
                }
            }
        }
    }
}
