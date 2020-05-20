<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    public $timestamps = false;
    /**
    * Get the payments.
    */
    public function payments()
    {
        return $this->hasMany('App\Payment','user_id');
    }
}
