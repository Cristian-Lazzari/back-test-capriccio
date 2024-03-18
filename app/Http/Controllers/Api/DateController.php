<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $wcf = $request->input("wcf");
            // Formatto la data e l'ora correnti in formato italiano
            $dataOraFormattate = Carbon::now()->format('d-m-Y H:i:s');

            $dataOraCarbon = Carbon::createFromFormat('d-m-Y H:i:s', $dataOraFormattate);
            $dataOraCarbon2 = Carbon::createFromFormat('d-m-Y H:i:s', $dataOraFormattate);
            // Ottieni il numero del giorno della settimana (da 0 a 6)
            $dayWeek = $dataOraCarbon->dayOfWeek;

            $ora1f = $dataOraCarbon->setTime(19, 30);//weekend //va un ora avanti non so perche ;)
            $ora2f = $dataOraCarbon2->setTime(20, 00);//sett
    
            // Calcolo la data di inizio considerando il giorno successivo a oggi
            $dataInizio = $dataOraCarbon->copy();
           // dd($dataInizio->format('H:i'));
            // Calcolo la data di fine considerando due mesi successivi alla data odierna
            $dataDiFineParz = $dataInizio->copy()->startOfMonth();
            $dataFine = $dataDiFineParz->copy()->addMonths(2)->endOfMonth();
        
           
            if(($dayWeek == 5 || $dayWeek == 6 || $dayWeek == 0) && $ora1f->gt($dataOraFormattate)){

                // Filtro dal giorno successivo a oggi e per i due mesi successivi
                $dates = Date::where('year', '>=', $dataInizio->year)
                    ->where('month', '>=', $dataInizio->month)
                    ->where(function ($query) use ($dataInizio) {
                        $query->where('month', '>', $dataInizio->month)
                            ->orWhere(function ($query) use ($dataInizio) {
                                $query->where('month', '=', $dataInizio->month)
                                    ->where('day', '>', $dataInizio->day)
                                    ->orWhere(function ($query) use ($dataInizio) {
                                        $query->where('day', '=', $dataInizio->day)
                                            ->where('time', '>=', $dataInizio->format('H:i'));
                                    });
                            });
                    })
                    ->where('year', '<=', $dataFine->year)
                    ->where('month', '<=', $dataFine->month)
                    ->get();
                }else if(($dayWeek == 1 || $dayWeek == 2 || $dayWeek == 3 || $dayWeek == 4) && $ora2f->gt($dataOraFormattate)){
   
                    $dates = Date::where('year', '>=', $dataInizio->year)
                    ->where('month', '>=', $dataInizio->month)
                    ->where(function ($query) use ($dataInizio) {
                        $query->where('month', '>', $dataInizio->month)
                            ->orWhere(function ($query) use ($dataInizio) {
                                $query->where('month', '=', $dataInizio->month)
                                    ->where('day', '>', $dataInizio->day)
                                    ->orWhere(function ($query) use ($dataInizio) {
                                        $query->where('day', '=', $dataInizio->day)
                                            ->where('time', '>=', $dataInizio->format('H:i'));
                                    });
                            });
                    })
                    ->where('year', '<=', $dataFine->year)
                    ->where('month', '<=', $dataFine->month)
                    ->get();
                }else{
        
                    // Filtro dal giorno successivo a oggi e per i due mesi successivi
                    $dataInizio = $dataInizio->addDay();
                    $dates = Date::where('year', '>=', $dataInizio->year)
                        ->where('month', '>=', $dataInizio->month)
                        ->where(function ($query) use ($dataInizio) {
                            $query->where('month', '>', $dataInizio->month)
                                ->orWhere(function ($query) use ($dataInizio) {
                                    $query->where('month', '=', $dataInizio->month)
                                        ->where('day', '>=', $dataInizio->day);
                                });
                        })
                        ->where('year', '<=', $dataFine->year)
                        ->where('month', '<=', $dataFine->month)
                        ->get();
            }
            $newDates = [];
            //dd($wcf);
            if($wcf == '0'){
                foreach ($dates as $data) {
                    if($data['visible_t']){
                       array_push($newDates, $data); 
                    }
                }
                
            }else if($wcf == '1'){
                foreach ($dates as $data) {
                    if($data['visible_fq'] || $data['visible_ft']){
                        if($data['status'] == 1 || $data['status'] == 3 || $data['status'] == 5 || $data['status'] == 7 ){

                            array_push($newDates, $data); 
                        }
                            
                    }
                }
                
            }else if($wcf == '2'){
                foreach ($dates as $data) {
                    //se anche solo un forno ha la disponibilità mostro la data, sara poi l'utente da front-end
                    // a notare che sono disponibili 0 pezzi di una delle due categorie
                    if($data['visible_d'] && ($data['res_pz_q'] < $data['max_pz_q'] || $data['res_pz_t'] < $data['max_pz_t'])){
                       array_push($newDates, $data); 
                    }
                }

            }
            

            
            return response()->json([
                'success' => true,
  
                "data_e_ora_attuali" => $dataOraFormattate,
                // "fineParziale" => $dataDiFineParz->day,
                "dataDiInizio" => $dataInizio->day . "/" . $dataInizio->month . "/" . $dataInizio->year,
                "dataDiFine" => $dataFine->day . "/" . $dataFine->month . "/" . $dataFine->year,
                'results' => $newDates,
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore del database: ' . $e->getMessage(),
            ]);
        } catch (Exception $e) {
            // Eccezioni generiche, stampo il messaggio restituito
            return response()->json([
                'success' => false,
                'error' => 'Si è verificato un errore durante l\'elaborazione della richiesta: ' . $e->getMessage(),
            ], 500);
        }
    }

    private $validations = [
        'year'  => 'required|integer|between:2023,2050',
        'month' => 'required|integer|between:1,12',
        'day'   => 'required|integer|between:1,31',
        'time'  => 'required|string|size:5',
    ];

    // restituisce una data in formato originale in base alla richiesta di prenotazione tavolo
    public function findDate(Request $request)
    {
        try {
            $request->validate($this->validations);

            $year = $request->input("year");
            $month = $request->input("month");
            $day = $request->input("day");
            $time = $request->input("time");

            $date = Date::where('year', $year)
                ->where('month', $month)
                ->where('day', $day)
                ->where('time', $time)
                ->get();
            if (!$date) {
                return response()->json([
                    'success' => false,
                    'message' => "Data non trovata",
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'results' => $date,
                ]);
            }
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore del database: ' . $e->getMessage(),
            ]);
        } catch (Exception $e) {
            // Eccezioni generiche, stampo il messaggio restituito
            return response()->json([
                'success' => false,
                'error' => 'Si è verificato un errore durante l\'elaborazione della richiesta: ' . $e->getMessage(),
            ], 500);
        }
    }
}
