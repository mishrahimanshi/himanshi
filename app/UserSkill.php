<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    //table name
    protected $table = 'userskills';

    protected $fillable = ['user_id','skills_id','created_at','updated_at'];


    public function users(){
        return $this->belongsTo('App/Users');
    }

    public function skills(){
        return $this->belongsTo('App/Skills');
    }
}
