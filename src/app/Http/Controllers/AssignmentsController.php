<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Devices;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    public function index()
    {
        $assignments = Assignment::query()->orderBy('id', 'desc')
            ->paginate(
                perPage: 10,
                page: 1
            );

        $organizations = Organization::all();

        return view('assignments.index', compact('assignments', 'organizations'));
    }

    public function items($offset, $limit)
    {
        $assignments = Assignment::query()->orderBy('id', 'desc');

//        if (request()->has('search')) {
//            $assignments = $assignments->where('name', 'like', '%' . request('search') . '%');
//        }

        $assignments = $assignments->paginate(
            perPage: $limit,
            page: $offset
        );

        return view('assignments.data', compact('assignments'));
    }

    public function set($id)
    {
        $devices = Devices::query()->where('organization_id', $id)->get();
        $users = User::query()->where('organization_id', $id)->get();

        return response()->json([
            'devices' => $devices,
            'users' => $users
        ]);
    }

    public function create(Request $request)
    {
        $assignment = new Assignment();
        $assignment->organization_id = $request->organizationID;
        $assignment->device_id = $request->deviceID;
        $assignment->user_id = $request->userID;
        $assignment->save();


        return response()->json($assignment);
    }

    public function edit($id)
    {
        $assignment = Assignment::query()->findOrFail($id);

        return response()->json($assignment);
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::query()->findOrFail($id);
        $assignment->organization_id = $request->organizationID;
        $assignment->device_id = $request->deviceID;
        $assignment->user_id = $request->userID;
        $assignment->save();

        return response()->json($assignment);

    }

    public function delete($id)
    {
        $assignment = Assignment::query()->findOrFail($id);
        $assignment->delete();

        return response()->json($assignment);
    }
}
