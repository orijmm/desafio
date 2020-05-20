<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $primaryKey = 'uuid';
    
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = ['uuid','payment_date','expires_at','status','user_id','clp_usd'];

    public $timestamps = false;
    /**
    * Get the client.
    */
    public function client()
    {
        return $this->belongsTo('App\Client','user_id');
    }
}
