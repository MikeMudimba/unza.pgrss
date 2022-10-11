<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Department extends Model
{

    //Table
    protected $table = 'department';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'school'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
