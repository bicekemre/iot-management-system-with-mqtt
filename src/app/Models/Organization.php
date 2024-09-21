<?php

namespace App\Models;

use App\Models\Scopes\OrganizationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    use HasFactory;


    public function users()
    {
        return $this->hasMany(User::class);
    }

    protected static function booted()
    {
        static::addGlobalScope('organization', function ($builder) {
            $user = Auth::user();
            if (Auth::check() && $user->is_admin == 0) {
                return $builder->where('id', $user->organization_id);
            }
        });
    }
}
