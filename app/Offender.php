<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Offender extends Model
{
    use Notifiable;

    protected $table = 'offenders';
    protected $fillable = [
        'FirstName',
        'LastName',
        'Gender',
        'Age',
        'IDCardNumber',
        'Occupation',
        'Nationality',
        'Address',
        'Province',
        'District',
        'Village',
        'MainBusiness',
        'MainNetwork',
        'Photo',
        'user_id',
        'Action',
    ];

    //----- relationship to Cases model ----------
    public function cases(){
        return $this->hasMany('App\MCase');
    }
    //----- relationship to Business model ----------
    public function businesses(){
        return $this->hasMany('App\Business');
    }
    //----- relationship to user model ----------
    public function user(){
        return $this->belongsTo('App\User');
    }
}
