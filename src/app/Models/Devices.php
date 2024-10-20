<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->type()->properties()->hasMany(Value::class, 'device_id', 'id');
    }
    public function values()
    {
        return $this->hasMany(Value::class, 'device_id', 'id');
    }

    public function value()
    {
        return $this->hasMany(Value::class, 'device_id', 'id');
    }

    protected static function booted()
    {
        $user = Auth::user();
        if (Auth::check()) {
            if ($user->is_admin == 0) {
                static::addGlobalScope(new OrganizationScope());
            }
        }
    }

    public function connection()
    {
        return $this->hasOne(Connection::class, 'device_id', 'id');
    }
}
