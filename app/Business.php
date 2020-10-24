<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'businesses';
    protected $fillable = [
        'offender_id',
        'CompanyName',
        'Owner',
        'Activity',
        'Address',
        'Country',
        'latitude',
        'longtitude',
        'Phone',
        'Email',
        'SocialNetwork',
        'CompanyLogo',
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
