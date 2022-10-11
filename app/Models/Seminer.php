<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Seminer extends Model
{

    //Table
    protected $table = 'seminer_week';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'project',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}