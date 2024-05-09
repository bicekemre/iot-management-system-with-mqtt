<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {


        return view('home.index');
    }

    public function profile()
    {
        $user = auth()->user();

        return view('home.profile', compact('user'));
    }


    public function clearNotifications()
    {
        $notifications = Notifications::where(['read_at' => null])->get();

        foreach ($notifications as $notification) {
            $notification->read_at = now();
            $notification->save();
        }

        return back();
    }

}
