<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    //Table name
    protected $table = 'skills';

    //Field name
    protected $fillable = ['parent_id','skill_name','description','created_at','updated_at'];

    public function jobskills(){
        return $this->hasMany('App/JobSkills','skills_id');
    }
}
