<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Intake extends Model
{

    //Table
    protected $table = 'intake';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'start_date',
        'end_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
