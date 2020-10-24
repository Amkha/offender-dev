<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    protected $table = 'networks';
    protected $fillable = [
        'MobName',
        'NetworkType',
        'NetworkActivity',
        'MainAddress',
        'Country',
        'MemberNumber',
        'CrimeLevel',
        'MobLogo',
        'user_id',
        'Action'
    ];

    //----- relationship to mcase model ----------
    public function offender(){
        return $this->belongsTo('App\Offender');
    }

     //----- relationship to user model ----------
     public function user(){
        return $this->belongsTo('App\User');
    }
}
