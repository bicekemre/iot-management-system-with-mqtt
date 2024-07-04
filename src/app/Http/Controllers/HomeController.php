<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Notifications;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $devices = Devices::all();

        return view('home.index', compact('devices'));
    }

    public function profile()
    {
        $user = auth()->user();

        return view('home.profile', compact('user'));
    }


    public function clearNotifications()
    {
        $notifications = Notifications::query()->where(['read_at' => null])->get();

        foreach ($notifications as $notification) {
            $notification->read_at = now();
            $notification->save();
        }

        return back();
    }

    public function chart($id)
    {
        $device = Devices::query()->findOrFail($id)->load('values.property');

        $startOfDay = now()->subDay()->startOfDay();
        $endOfDay = now()->subDay()->endOfDay();

        $values = $device->values()
            ->whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->whereTime('created_at', '>=', '08:00:00')
            ->whereTime('created_at', '<=', '20:00:00')
            ->pluck('value')
            ->toArray();

        $time = $device->values()
            ->whereDate('created_at', '>=', $startOfDay)
            ->whereDate('created_at', '<=', $endOfDay)
            ->whereTime('created_at', '>=', '08:00:00')
            ->whereTime('created_at', '<=', '20:00:00')
            ->pluck('created_at')
            ->toArray();

        return response()->json($device);
    }

}
