<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSkill extends Model
{
    //Table name
    protected $table = 'job_skills';

    //Field name
    protected $fillable = [
      'job_id','skills_id','created_at','updated_at'
    ];

    public function jobs(){
        return $this->belongsTo('App/Jobs');
    }
}
