<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Nationality extends Model
{
    use Notifiable;

    protected $table = 'nationalities';
    protected $fillable = [
        'id',
        'NationEng',
        'NationLao'
    ];

    
}
