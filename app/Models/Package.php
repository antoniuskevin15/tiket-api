<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    //Punya 1 user (Yg dikirimin)
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
