<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Programme extends Model
{

    //Table
    protected $table = 'programme';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'department',
        'level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
