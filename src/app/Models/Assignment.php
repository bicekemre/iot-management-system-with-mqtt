<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function device()
    {
        return $this->hasOne(Devices::class, 'id', 'device_id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function organization()
    {
        return $this->hasOne(Organization::class, 'id', 'organization_id');
    }
}
