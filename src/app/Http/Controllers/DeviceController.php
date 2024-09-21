<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use App\Models\Organization;
use App\Models\Type;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Devices::query()->orderBy('id', 'desc')->paginate(
            perPage: 10,
            page: 1
        );

       $types = Type::all();
       $organizations = Organization::all();
        return view('devices.index', compact('devices', 'types', 'organizations'));
    }

    public function items($offset, $limit)
    {
        $devices = Devices::query()->orderBy('id', 'desc');

        if (\request()->has('search')) {
            $devices = $devices->where('name', 'like', '%' . \request('search') . '%');
        }
        $devices = $devices->paginate(
            perPage: $limit,
            page: $offset
        );

        return view('devices.data', compact('devices'));
    }

    public function item($id)
    {
        $device = Devices::findOrFail($id);

        $latestValues = $device->values()
            ->select('property_id', 'value', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('property_id');

        $latestValues->load('property');

        $device->setRelation('values', $latestValues);

        return response()->json($device);
    }


    public function create(Request $request)
    {
        $device = new Devices();

        $device->name = $request->name;
        $device->uuid = $request->uuid;
        $device->type_id = $request->type;
        $device->organization_id = $request->organization;

        $device->save();

        return response()->json($device);
    }

    public function edit($id)
    {
        $device = Devices::query()->findOrFail($id);

        return response()->json($device);
    }

    public function update(Request $request, $id)
    {
        $device = Devices::query()->findOrFail($id);

        $device->name = $request->name;
        $device->uuid = $request->uuid;
        $device->type_id = $request->type;
        $device->organization_id = $request->organization;

        $device->save();

        return response()->json($device);
    }

    public function delete($id)
    {
        $device = Devices::query()->findOrFail($id);
        $device->delete();

        return response()->json($device);
    }


    public function start()
    {
        dispatch(new MqttConnection());
        return response()->json('status', 1);
    }

    public function stop()
    {
        dispatch(new MqttConnection(true));
        return response()->json('status', 0);
    }
}
