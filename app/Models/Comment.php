<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{

    //Table
    protected $table = 'comment';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'user',
        'project',
        'date_made',
        'stage',
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
