<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ModeOfTraining extends Model
{

    //Table
    protected $table = 'mode_of_training';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
