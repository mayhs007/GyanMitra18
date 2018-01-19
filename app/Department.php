<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    function events(){
        return $this->hasMany('App\Event');
    }
    protected $image_path = '/images/';
    function getImageUrl(){
        if(empty($this->image_name)){
            return $this->image_path . 'default.png';            
        }
        else{
            return $this->image_path . $this->image_name;            
        }
    }

}
