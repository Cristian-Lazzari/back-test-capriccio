<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\OrderProject;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function destroy($id)
    {
        $notification = Notification::where('id', $id)->firstOrFail();
        $notification->delete();

        return redirect()->back();
    }

    public function showAndDestroy($id)
    {
        $notification = Notification::where('id', $id)->firstOrFail();
        $source = $notification->source ? 'orders' : 'reservations';
        if ($notification->source) {
            $order = Order::where('id', $notification->source_id)->firstOrFail();
            $orderProject = OrderProject::all();
            $notification->delete();
            return view('admin.orders.show', compact('order', 'orderProject'));
        } else {
            $reservation = Reservation::where('id', $notification->source_id)->firstOrFail();
            $notification->delete();
            return view('admin.reservations.show', compact('reservation'));
        }
    }

    public function clearAll()
    {
        DB::table('notifications')->truncate();

        return redirect()->back();
    }
}
