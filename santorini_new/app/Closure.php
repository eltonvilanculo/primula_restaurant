<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Closure extends Model
{
    protected $fillable = ['value','date','user_id'];

    public function user(){
      return $this -> belongsTo('App\User');
    }
}

