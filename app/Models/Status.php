<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Status extends Model
{

    //Table
    protected $table = 'status';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'color',
        'description'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
