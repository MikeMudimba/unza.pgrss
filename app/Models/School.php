<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class School extends Model
{

    //Table
    protected $table = 'school';

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
