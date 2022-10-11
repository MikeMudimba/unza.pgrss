<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProjectAttachment extends Model
{

    //Table
    protected $table = 'project_attachment';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'project',
        'name',
        'project_attachment_type',
        'downlink',
        'format',
        'stage'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

}
