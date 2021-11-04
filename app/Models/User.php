<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];

    protected $appends = ['role', 'user_profile'];

    public function findForPassport($identifier)
    {
        return $this->orWhere('email', $identifier)->first();
    }

    public function themeSettings()
    {
        return $this->hasOne(ThemeSettings::class);
    }

    public function role(){
        return $this->hasOneThrough(Role::class, UserRole::class);
    }

    public function getRoleAttribute(){
        return $this->role();
    }

    public function userProfile(){
        return $this->hasOneThrough(Image::class, UserProfile::class);
    }

    public function getUserProfileAttribute(){
        return $this->userProfile();
    }
}
