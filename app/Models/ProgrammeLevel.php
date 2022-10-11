<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProgrammeLevel extends Model
{

    //Table
    protected $table = 'programme_level';

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
