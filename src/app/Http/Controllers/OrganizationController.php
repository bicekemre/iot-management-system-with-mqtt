<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::query()->orderBy('id', 'desc')->paginate(
            perPage: 10,
            page: 1
        );

        return view('organization.index', compact('organizations'));
    }

    public function items($offset, $limit)
    {
        $organizations = Organization::query()->orderBy('id', 'desc');

        if (\request()->has('search')) {
            $organizations = $organizations->where('name', 'like', '%' . \request('search') . '%');
        }
        $organizations = $organizations->paginate(
            perPage: $limit,
            page: $offset
        );

        return view('organization.data', compact('organizations'));
    }


    public function create(Request $request)
    {
        $organization = new Organization();

        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->phone = $request->phone;
        $organization->address = $request->address;

        $organization->save();

        return response()->json($organization);
    }

    public function edit($id)
    {
        $organization = Organization::query()->findOrFail($id);

        return response()->json($organization);
    }

    public function update(Request $request, $id)
    {
        $organization = Organization::query()->findOrFail($id);

        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->phone = $request->phone;
        $organization->address = $request->address;

        $organization->save();

        return response()->json($organization);
    }

    public function delete($id)
    {
        $organization = Organization::query()->findOrFail($id);

        $organization->delete();

        return response()->json($organization);
    }
}
