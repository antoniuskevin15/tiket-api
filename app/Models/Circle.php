<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    protected $guarded = [
        'id',
    ];

    //Punya user siapa aja
    public function users(){
        return $this->hasMany(User::class, 'circle_id');
    }

    //Circle ini owner nya siapa
    public function owner(){
        return $this->belongsTo(User::class);
    }
}