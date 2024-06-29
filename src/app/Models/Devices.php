<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'device_id', 'id');
    }
}
