<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'learning_hour'
    ];

    // /**
    //  * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'learning_hour' => 'time',
    // ];
}
