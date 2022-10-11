<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProjectAttachmentType extends Model
{

    //Table
    protected $table = 'project_attachment_type';

    //Primary key
    protected $primaryKey = 'id';

    //timestamps
    public $timestamps = false;
    
    protected $fillable = [
        'name',
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
