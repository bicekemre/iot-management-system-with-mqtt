<?php

namespace App\Http\Controllers;

use App\Jobs\MqttConnection;
use App\Models\Connection;
use App\Models\Devices;
use App\Models\Organization;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

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


    public function start(Request $request)
    {
        $commandName = 'php artisan mqtt:listen > /dev/null 2>&1 & echo $!';
        $topic = $request->input('topic');

        $command = "php artisan $commandName $topic > /dev/null 2>&1 & echo $!";
        $pid = exec($command);

        $checkConnection = Connection::where('device_id', $request->deviceId)->first();

        if (!$checkConnection)
        {
            $connection = new Connection();
            $connection->device_id = $request->deviceId;
            $connection->topic = $request->topic;
            $connection->pid = $pid;
            $connection->status = 'running';
            $connection->save();
        }else{
            $checkConnection->topic = $request->topic;
            $checkConnection->status = 'running';
            $checkConnection->save();
        }

        return response()->json(['status' => 'Command started', 'pid' => $pid]);
    }

    public function stop(Request $request)
    {
        $connectionStatus = Connection::where('device_id', $request->device_id)->first();

        if ($connectionStatus && $connectionStatus->pid) {
            exec("kill {$connectionStatus->pid}");

            $connectionStatus->update(['status' => 'stopped', 'pid' => null]);

            return response()->json(['status' => 'Command stopped']);
        }

        return response()->json(['status' => 'Command not running']);
    }

    public function connectionStatus($id)
    {
        $connectionStatus = Connection::where('device_id', $id)->first();

        if ($connectionStatus && $connectionStatus->status === 'running') {
            return response()->json(['status' => 'running']);
        } else {
            return response()->json(['status' => 'stopped']);
        }
    }
}
