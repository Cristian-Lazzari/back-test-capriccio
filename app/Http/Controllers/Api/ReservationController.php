<?php

namespace App\Http\Controllers\Api;

use DateTime;
use Exception;
use App\Models\Date;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\confermaPrenotazione;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\confermaPrenotazioneAdmin;
use Illuminate\Database\QueryException;

class ReservationController extends Controller
{
    private $validations = [
        'name'      => 'required|string|max:50',
        'phone'     => 'required|string|max:20',
        'email'     => 'required|email|max:100',
        'n_person'  => 'required|string|max:10',
        'message'   => 'nullable|string|max:1000',
    ];

    public function store(Request $request)
    {
        try {
            $request->validate($this->validations);

            $data = $request->all();

            $newOrder = new Reservation();
            $newOrder->name = $data['name'];
            $newOrder->phone = $data['phone'];
            $newOrder->email = $data['email'];
            $newOrder->n_person = intval($data['n_person']);
            $newOrder->message = $data['message'];
            $newOrder->status = 0;

            // recupero data e orario in questione 
            $date = Date::where('id', $data['date_id'])->firstOrFail();

            $maximum = $date->reserved + $newOrder->n_person;

            if ($maximum <= $date->max_res) {
                $date->reserved = $date->reserved + $newOrder->n_person;
                if ($date->reserved == $date->max_res) {
                    $date->visible_t = 0;
                }
            } else {
                // se non ci sono più posti rispondo picche
                return response()->json([
                    'success' => false,
                    'message' => 'Il numero massimo di prenotazioni per questa data e orario è già stato raggiunto',
                ]);
            }
            $newOrder->date_slot = $date->date_slot;
            $newOrder->save();

            // Invio notifica a dashboard
            $newNot = new Notification();
            $newNot->title = 'Nuova prenotazione da: ' . $data['name'];
            $newNot->message = `Hai una nuova prenotazione: ` . $data['n_person'] . ' persone per ' . $date->date_slot;
            $newNot->source = 0;
            $newNot->source_id = $newOrder->id;

            // Salvo la data, la prenotazione e la notifica
            $date->save();
            $newNot->save();

            // invia mail
            $mail = new confermaPrenotazione($newOrder);
            Mail::to($data['email'])->send($mail);

            $mailAdmin = new confermaPrenotazioneAdmin($newOrder);
            Mail::to('info@pizzeria-capricciodileo.it')->send($mailAdmin);


            return response()->json([
                'success' => true,
                "prenotazione" => $newOrder,
                // "reserved" => $date->reserved,
                "data" => $date
            ]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore del database: ' . $e->getMessage(),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Si è verificato un errore: ' . $e->getMessage(),
            ]);
        }
    }
}
