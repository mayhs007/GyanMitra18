<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // 
    
    protected $fillable =  ['title', 'category_id','department_id', 'description', 'image_name', 'rules', 'event_date', 'start_time', 'end_time', 'min_members', 'max_members', 'max_limit', 'contact_email', 'allow_gender_mixing','venue','prelims','round1','round2','finals','pg_amount','amount','resource_person','sae_amount','ie_amount','iete_amount'];
    protected $image_path = '/images/events/';
    function category(){
        return $this->belongsTo('App\Category');
    }
    function users(){
        return $this->morphedByMany('App\User', 'registration');
    }
    function teams(){
        return $this->morphedByMany('App\Team', 'registration');
    }
    function rejections(){
        return $this->hasMany('App\Rejection');
    }
    function organizers(){
        return $this->belongsToMany('App\User', 'organizings');        
    }
    function prizes(){
        return $this->hasMany('App\Prize');
    }
    function department(){
        return $this->belongsTo('App\Department');
    }
    function hasPrizes(){
        if($this->prizes->count() == 0){
            return false;
        }
        else{
            return true;
        }
    }
    function getOrganizersList(){
        $organizerEmails = [];
        foreach($this->organizers as $organizer){
            array_push($organizerEmails, $organizer->email);
        }
        return implode(",", $organizerEmails);
    }
    function getRulesList(){
        $string=trim($this->rules);
        $rules = explode('!', $string);
        $rules_list = [];
        foreach($rules as $rule){
            array_push($rules_list, trim($rule));
        }
        return $rules_list;
    }
    function getDescriptionList()
    {
        $descriptions=explode('!',$this->description );
        $description_list=[];
        foreach($descriptions as $description){
            array_push($description_list,trim($description));
        }
        return $description_list;
    }
    function getDate(){
        $date = date_create($this->event_date);
        return date_format($date, 'j M Y');
    }
    function getStartTime(){
        $time = date_create($this->start_time); 
        return date_format($time, 'h:i A');               
    }
    function getEndTime(){
        $time = date_create($this->end_time); 
        return date_format($time, 'h:i A');               
    }
    function getPrelimsTime(){
        $time = date_create($this->prelims); 
        return date_format($time, 'h:i A');               
    }
    function getFinalsTime(){
        $time = date_create($this->finals); 
        return date_format($time, 'h:i A');               
    }
    function getResourcePersonList()
    {
       

            $resource_persons=explode('!',$this->resource_person );
            $resource_person_list=[];
            foreach($resource_persons as $resource_person){
                array_push($resource_person_list,trim($resource_person));
            }
            return $resource_person_list;
        
    }
    function getImageUrl(){
        if(empty($this->image_name)){
            return $this->image_path . 'default.png';            
        }
        else{
            return $this->image_path . $this->image_name;            
        }
    }
    function isGroupEvent(){
        return $this->max_members>1;
    }
    function noOfConfirmedRegistration(){
        $count = 0;
        if($this->isGroupEvent()){
            foreach($this->teams as $team){
                if($team->user->isConfirmed()){
                    $count++;
                }
            }
        }
        else{
            foreach($this->users as $user){
                if($user->isConfirmed()){
                    $count++;
                }
            }
        }
        return $count;
    }
    function hasPgAmount()
    {
        if($this->pg_amount!=0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function hasSaeAmount()
    {
        if($this->sae_amount!=0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function hasIeAmount()
    {
        if($this->ie_amount!=0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function hasIeteAmount()
    {
        if($this->iete_amount!=0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
