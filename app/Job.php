<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // Table Name
    protected $table = "jobs";

    //Fields
    protected $fillable = [
        'job_title','job_description','created_at','updated_at'
    ];

    public function jobskills(){
        return $this->hasMany('App\JobSkill','job_id');
    }
}
