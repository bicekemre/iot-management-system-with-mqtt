<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function device()
    {
        return $this->belongsTo(Devices::class);
    }

    public function values()
    {
        return $this->hasMany(Value::class);
    }
}
