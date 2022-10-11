<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Project extends Model
{

    //Table
    protected $table = 'project';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'student',
        'name',
        'start_date',
        'end_date',
        'stage',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
