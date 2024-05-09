<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->orderBy('id', 'desc')
        ->paginate(
            perPage: 10,
            page: 1
        );

        return view('users.index', compact('users'));
    }

    public function items($offset, $limit)
    {
        $users = User::query()->orderBy('id', 'desc');

        if (\request()->has('search')) {
            $search = \request()->get('search');
            $users->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        $users = $users->paginate(
            perPage: $limit,
            page: $offset
        );
        return view('users.data', compact('users'));
    }
}
