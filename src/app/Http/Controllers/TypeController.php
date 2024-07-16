<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Type;
use App\Models\Value;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $type = Type::query()->orderBy('id', 'desc')->paginate(
            perPage: 10,
            page: 1
        );

        return view('type.index', compact('type'));
    }

    public function items($offset, $limit)
    {
        $type = Type::query()->orderBy('id', 'desc');

        if (\request()->has('search')) {
            $search = \request()->get('search');
            $type->where('name', 'like', '%' . $search . '%');
        }

        $types = $type->paginate(
            perPage: $limit,
            page: $offset
        );
        return view('type.data', compact('types'));

    }

    public function create(Request $request)
    {
        $type = new Type();
        $type->name = $request->name;
        $type->save();

        foreach ($request->properties as $property) {
            Property::query()->create([
               'name' => $property['name'],
                'type_id' => $type->id,
                'min' => $property['min'],
                'max' => $property['max'],
            ]);
        }

        return response()->json($type);
    }

    public function edit($id)
    {
        $type = Type::query()->findOrFail($id)->load('properties');

        return response()->json($type);
    }

    public function update(Request $request,$id)
    {
        $type = Type::query()->findOrFail($id);
        $type->name = $request->type_name;
        $type->save();

        $currentProperties = $type->properties()->pluck('id')->toArray();

        $newProperties = $request->properties;
        foreach ($newProperties as $property) {
            $updatedProperty = Property::query()->updateOrCreate(
                [
                    'name' => $property['name'],
                    'min' => $property['min'],
                    'max' => $property['max'],
                ],
                ['type_id' => $type->id],
            );

            if (($key = array_search($updatedProperty->id, $currentProperties)) !== false) {
                unset($currentProperties[$key]);
            }
        }


        foreach ($currentProperties as $propertyId) {
            $property = Property::findOrFail($propertyId);
            if ($property) {
                $property->values()->delete();
                $property->delete();
            }
        }

        Property::destroy($currentProperties);

        return response()->json($type->load('properties'));
    }

    public function delete($id)
    {
        $type = Type::query()->findOrFail($id);
        $type->delete();

        return response()->json($type);
    }
}
