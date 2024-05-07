<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];


    // リレーションの定義 多対１
    public function users(){
        return$this->belongsTo('App\User');
    }
}
