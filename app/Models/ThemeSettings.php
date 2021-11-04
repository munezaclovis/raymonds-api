<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeSettings extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'themeColor',
        'fontStyle',
        'lightVersion',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
