<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class MCase extends Model
{
    use Notifiable;

    protected $table = 'cases';
    protected $fillable = [
        'offender_id',
        'DetectedDate',
        'Type',
        'ItemNumber',
        'Unit',
        'Amount',
        'CaseDescription',
        'Evidence',
        'Status',
        'Location',
        'Participant1',
        'Participant2',
        'Participant3',
        'Participant4',
        'Participant5',
        'Participant6',
        'User_id',
        'Action',
    ];

    //----- relationship to mcase model ----------
    public function offender(){
        return $this->belongsTo('\App\Offender');
    }
}
