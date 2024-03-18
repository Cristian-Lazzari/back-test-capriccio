<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use Carbon\Carbon;
use App\Models\Date;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\orderAnnullato;
use App\Mail\orderConfermato;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(15);
        $orderProject = OrderProject::all();

        return view('admin.orders.index', compact('orders', 'orderProject'));
    }

    public function filters(Request $request)
    {
        $status = strval($request->input('status'));
        $name = $request->input('name');
        $date_order = $request->input('date_order');
        $delivery = $request->input('delivery');
        $dateok = $request->input('dateok');
        $selected_date = Carbon::parse($request->input('selected_date'))->format('d/m/Y');

        $query = Order::query();

        if ($status == '0' || $status == '1' || $status == '2') {
            $query->where('status', $status);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($selected_date && $dateok) {
            $query->where('date_slot', 'like', $selected_date . '%');
            $selected_date = Carbon::parse($request->input('selected_date'))->format('Y-m-d');
        }

        if ($delivery && $delivery !== 'nul') {
            if ($delivery == 1) {
                $query->where('comune', '!=', '0');
            } else {

                $query->where('comune', '0');
            }
        }

        if ($date_order == 1) {
            $query->orderBy('date_slot', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(15);
        $orderProject  = orderProject::all();

        return view('admin.orders.index', compact('orders', 'orderProject', 'status', 'name', 'date_order', 'selected_date', 'delivery', 'dateok'));
    }


    public function show($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        $orderProject = OrderProject::all();
        return view('admin.orders.show', compact('order', 'orderProject'));
    }

    public function confirmOrder(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $notification = $request->input('confirm');

        if ($order && $notification && $order->status !== 1) {

            if ($order->status == 2) {
                $order->status = 1;
                $order->save();
                $date = Date::where('date_slot', $order->date_slot)->first();
                $date->reserved_pz += $order->total_pz;
                $date->save();
            } else {
                $order->status = 1;
                $order->save();
            }

            if ($notification == "wa") {

                return redirect("https://wa.me/" . '39' . $order->phone . "?text=Le confermiamo che abbiamo accettato la sua prenotazione. Buona serata!");
            } else if ($notification == "em") {
                // Invio Email
                try {
                    $mail = new orderConfermato($order);
                    Mail::to($order['email'])->send($mail);
                } catch (Exception) {
                    return redirect()->back()->with('email_error', true);
                }
                return redirect()->back()->with('confirm_success', true);
            } else {
                return redirect()->back()->with('confirm_success', true);
            }
        } else {
            return redirect()->back()->with('error_confirm', true);
        }
    }

    public function rejectOrder(Request $request, $order_id)
    {

        $order = Order::find($order_id);
        $notification = $request->input('confirm');

        if ($order && $notification && $order->status !== 2) {

            $order->status = 2;
            $order->save();
            $date = Date::where('date_slot', $order->date_slot)->first();
            $date->reserved_pz_q -= $order->total_pz_q;
            if ($date->reserved_pz_q < $date->max_pz_q) {
                $date->visible_fq = 1;
                $date->save();
            }
            $date->reserved_pz_t -= $order->total_pz_t;
            if ($date->reserved_pz_t < $date->max_pz_t) {
                $date->visible_ft = 1;
                $date->save();
            }
            if ($order->comune !== '0' && $order->civico !== '0' && $order->comune !== '0') {
                $date->visible_d = 1;
                $date->save();
            }


            if ($notification == "wa") {

                return redirect("https://wa.me/" . '39' . $order->phone . "?text=Le confermiamo che abbiamo accettato la sua prenotazione. Buona serata!");
            } else if ($notification == "em") {
                // Invio Email
                try {
                    $mail = new orderAnnullato($order);
                    Mail::to($order['email'])->send($mail);
                } catch (Exception) {
                    return redirect()->back()->with('email_error', true);
                }

                return redirect()->back()->with('reject_success', true);
            } else {
                return redirect()->back()->with('reject_success', true);
            }
        } else {
            return redirect()->back()->with('error_reject', true);
        }
    }

    public function create()
    {
        // Formatto la data e l'ora correnti in formato italiano
        $dataOraFormattate = Carbon::now()->format('d-m-Y H:i:s');

        // Dalla data formattata (stringa) ottengo un oggetto sul quale posso operare
        $dataOraCarbon = Carbon::createFromFormat('d-m-Y H:i:s', $dataOraFormattate)->addDay();

        // Calcolo la data di inizio considerando il giorno successivo a oggi
        $dataInizio = $dataOraCarbon->copy()->startOfDay();

        // Calcolo la data di fine considerando due mesi successivi alla data odierna
        $dataDiFineParz = $dataInizio->copy()->startOfMonth();
        $dataFine = $dataDiFineParz->copy()->addMonths(1)->endOfMonth();


        // Filtro dal giorno successivo a oggi e per i due mesi successivi e conotrollo che o visible_fq o vible_ft siano uguali a 1
        $dates = Date::whereIn('status', [1, 3, 4, 5, 6, 7])
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
        $addresses = Address::all();
        return view('admin.orders.create', compact('dates', 'addresses'));
    }

    private $validations = [
        'name'          => 'required|string|min:5|max:50',
        'phone'         => 'required|integer',
        'email'         => 'email|max:100',
        'message'       => 'nullable|string|min:5|max:1000',
        'date_id'       => 'required',

        'total_pz_t'    => 'required',
        'total_pz_q'    => 'required',
    ];
    public function store(Request $request)
    {
        $request->validate($this->validations);
        $data = $request->all();
        $date = Date::where('id', $data['date_id'])->firstOrFail();

        $newOrder = new Order();
        $newOrder->name          = $data['name'];
        $newOrder->phone         = $data['phone'];
        if ($data['email']) {
            $newOrder->email         = $data['email'];
        } else {
            $newOrder->email = 'email@example.com';
        }
        $newOrder->total_price   = $data['total_price'] * 100;

        $newOrder->total_pz_q    = $data['total_pz_q'];
        $newOrder->total_pz_t    = $data['total_pz_t'];

        $newOrder->message       = $data['message'];
        $newOrder->status        = 0;
        if (isset($data['comune'])) {
            $newOrder->comune = $data['comune'];
        }
        if (isset($data['civico'])) {
            $newOrder->civico = $data['civico'];
        }
        if (isset($data['indirizzo'])) {
            $newOrder->indirizzo = $data['indirizzo'];
        }
        if (isset($data['comune']) && isset($data['civico']) && isset($data['indirizzo'])) {
            $date->reserved_domicilio++;
            if ($date->reserved_domicilio >= $date->max_domicilio) {
                $date->visible_d = 0;
            };
        }

        $newOrder->date_slot = $date->date_slot;

        $maximum_t = $date->reserved_pz_t + $newOrder->total_pz_t;
        $maximum_q = $date->reserved_pz_q + $newOrder->total_pz_q;

        if (isset($data['max_check'])) {
            $date->reserved_pz_q = $date->reserved_pz_q + $newOrder->total_pz_q;
            $date->reserved_pz_t = $date->reserved_pz_t + $newOrder->total_pz_t;

            if ($date->reserved_pz_q >= $date->max_pz_q) {
                $date->visible_fq = 0;
            }
            if ($date->reserved_pz_t >= $date->max_pz_t) {
                $date->visible_ft = 0;
            }
        } else {
            if ($maximum_t <= $date->max_pz_t && $maximum_q <= $date->max_pz_q) {
                $date->reserved_pz_t = $date->reserved_pz_t + $newOrder->total_pz_t;
                $date->reserved_pz_q = $date->reserved_pz_q + $newOrder->total_pz_q;

                if ($date->reserved_pz_q == $date->max_pz_q) {
                    $date->visible_fq = 0;
                }
                if ($date->reserved_pz_t == $date->max_pz_t) {
                    $date->visible_ft = 0;
                }
                $date->save();
                $newOrder->save();

                return redirect()->route('admin.orders.create')->with('reserv_success', true);
            } else {
                return redirect()->route('admin.orders.create')->with(['max_res_check' => true, 'inputValues' => $data]);
            }
        }

        // dd("date: " . $date, "order: " . $newOrder);
        $date->save();
        $newOrder->save();

        return redirect()->route('admin.orders.create')->with('reserv_success', true);
    }
}
