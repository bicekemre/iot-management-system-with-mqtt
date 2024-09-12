<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public $rules = [
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    ];

    public function messages()
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'Email address is already taken.',
            'password.required' => 'Password is required.'
        ];
    }

    public function index()
    {
        $users = User::query()->orderBy('id', 'desc');

        $organization_id = Cookie::get('organization_id');
        if ($organization_id){
            $users = $users->where('organization_id', $organization_id);
        }

        $users = $users->paginate(
            perPage: 10,
            page: 1
        );

        $roles = Role::all();
        $organizations = Organization::all();

        return view('users.index', compact('users', 'roles', 'organizations'));
    }

    public function items($offset, $limit)
    {
        $users = User::query()->orderBy('id', 'desc');

        if (\request()->has('search')) {
            $search = \request()->get('search');
            $users->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }

        $organization_id = Cookie::get('organization_id');
        if ($organization_id){
            $users = $users->where('organization_id', $organization_id);
        }

        $users = $users->paginate(
            perPage: $limit,
            page: $offset
        );
        return view('users.data', compact('users'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required']
        ], $this->messages());

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role;
        $user->organization_id = $request->organization;

        $user->save();

        return response()->json($user);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role_id,
            'organization' => $user->organization_id,
        ]);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($id)],
        ], $this->messages());

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->organization_id = $request->organization;

        $user->save();

        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        if ($request->password != $request->repassword){
            return redirect()->route('profile')->withErrors('passwords are not matches');
        }
        $user = \auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return redirect()->route('profile');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true]);
    }

}
