<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Dissertations extends Model
{

    //Table
    protected $table = 'dissertation';

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
