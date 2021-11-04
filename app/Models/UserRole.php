<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function role(){
        return $this->hasOne(Role::class);
    }

    public function user(){
        return $this->hasOne(User::class);
    }
}
