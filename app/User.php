<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\team;
use App\TeamMember;
use App\Event;
use Auth;
//use App\Registration;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','college_id','level_of_study','gender','mobile','type','email', 'password', 'activated', 'activation_code','confirmation','Accomodation_Confirmation','present','sae_id','ie_id','iete_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    function events(){
        return $this->morphToMany('\App\Event', 'registration');
    }
    function payment(){
        return $this->hasOne('App\Payment');
    }
    function roles(){
        return $this->belongsToMany('App\Role');
    }
    function rejections(){
        return $this->hasMany('App\Rejection');
    }
    function accomodation(){
        return $this->hasOne('App\Accomodation');
    }
    function organizings(){
        return $this->belongsToMany('App\Event', 'organizings');
    }
    function prizes(){
        return $this->hasMany('App\Prize');
    }
  
    // Get all the users to be paid by the user eliminating duplicates
    function getUsersToPay(){
        $userIds = [];
        $users = [];
        // Add the current user and his id
        array_push($userIds, $this->id);
        array_push($users, $this);
        // Get ids of all member users without duplication
        foreach($this->teams as $team){
            foreach($team->teamMembers as $teamMember){
                if(array_search($teamMember->user->id, $userIds) === false){
                    array_push($userIds, $teamMember->user->id);
                    // Push the user as he is not being duplicated
                    array_push($users, $teamMember->user);        
                }
            }
        }
        $usersToPay = [];
        // Get users to be paid
        foreach($users as $user){
            if(!$user->hasPaid()){
                array_push($usersToPay, $user);            
            }
        }
        
        return $usersToPay;
    }
    function hasRequestedAccomodation(){
        if($this->accomodation){
            return true;
        }
        else{
            return false;
        }
    }
    function hasAccomodationAcknowledged(){
        if($this->hasRequestedAccomodation() && $this->accomodation->status){
            return true;
        }
        else{
            return false;
        }
    }
    function hasPaid(){
        if($this->payment==Null)
        {
            return false;
        }
        else
        {
            if($this->payment->mode_of_payment=='dd')
            {
                if($this->payment->file_name == null){
                    return false;
                }
                else
                {
                   return true;
                   
                }
            }
            else
            {
                if($this->payment->transaction_id== null){
                    return false;
                }
                else
                {
                   return true;
                   
                }
            }
           
            
        }
      
    }
    function hasConfirmedDD()
    {
        if($this->payment->status == 'ack')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function hasPaidAccomodation(){
        if($this->accomodation==Null)
        {
            return false;
        }
        else
        {
            if($this->accomodation->acc_mode_of_payment=='dd')
            {
                if($this->accomodation->acc_file_name == null){
                    return false;
                }
                else
                {
                   return true;
                   
                }
            }
            else
            {
                if($this->accomodation->acc_transaction_id== null){
                    return false;
                }
                else
                {
                   return true;
                   
                }
            }
           
            
        }
    }
    function hasConfirmedAccomodation()
    {
        if($this->Accomodation_Confirmation == true)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
 
    // Check if the user is organizing an event
   function isOrganizing($event_id){
        if($this->organizings()->find($event_id)){
            return true;
        }
    }
    // Find the team a user has registered for an event
    function teamLeaderFor($event_id){
        $event = Event::find($event_id);
        return $event->teams->where('user_id', $this->id)->first();
    }
    // find the team for which the user has been selected as team member
    function teamMemberFor($event_id){
        $event = Event::find($event_id);
        foreach($event->teams as $team){
            if($team->teamMembers->where('user_id', $this->id)->count()){
                return $team;
            }
        }
    }
    function teamEvents(){
        $events = [];
        //  Add events in which the user is team leader
        foreach($this->teams as $team){
            array_push($events, $team->events()->first());
        }
        //  Add events in which the user is a team member        
        foreach($this->teamMembers as $teamMember){
            array_push($events, $teamMember->team->events()->first());
        }
        // Return as collections
        return collect($events);
    }
     function hasRegisteredEvent($event_id){
        $event = Event::find($event_id);
        if($event->isGroupEvent()){
            foreach($this->teams as $team){
                if($team->hasRegisteredEvent($event_id)){
                    return true;
                }
            }  
            if($this->isTeamMember($event_id)){
                return true;
            }
        }
        else{
             if($this->events()->find($event_id)){
                 return true;
             }
             else{
                 return false;
             }
        }
        return false;
     }
    function hasRegistered($event_id)
    {
        
        if($this->events()->find($event_id))
        {
            return true;
        }
        else{
            return false;
        }
    }
    function college(){
        // Get the college of the student
        return $this->belongsTo('App\College');
    }
    function teams(){
        return $this->hasMany('App\Team');
    }
    function teamMembers(){
        return $this->hasMany('App\TeamMember');
    }
     function hasConfirmed(){
        if($this->confirmation==true){
            return true;
        }
        else{
            return false;
        }
    }
    
    function needApproval(){
        $teamCount = $this->teams->count();
        $teamMembersCount = $this->teamMembers->count();
        // Need approval if the user is not a team leader and does not belong to any team
        if($teamCount || !$teamMembersCount){
            return true;
        }
        else{
            return false;
        }
    }
    function isTeamMember($event_id){
        return $this->teamEvents()->where('id', $event_id)->count();
    }
    function isTeamLeader($event_id){
        $event = Event::find($event_id);
        if($event->teams()->where('user_id', $this->id)->count()){
            return true;
        }
        else{
            return false;
        }
    }
    function isParticipating(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() == 0){
            return false;
        }
        else{
            return true;
        }
    }
    function hasConfirmedTeams(){
        foreach($this->teams as $team){
            if(!$team->isConfirmed()){
                return false;
            }
        }
        return true;
    }
    function canConfirm()
    {
        if($this->isParticipating())
        {
            if($this->hasWorkshop())
            {
                return true;
            }
            else
            {
                if($this->hasSureEvents())
                {
                    return true;
                }                
            }
        }
        else
        {
            return false;
        }
    }
    function hasTeams(){
        $teamCount = $this->teams->count();  
        return $teamCount; 
    }
    function isAcknowledged(){
        if($this->hasConfirmed()){
            if($this->confirmation->status){
                return true;
            }
        }
        return false;
    }
    function isConfirmed(){
        if($this->needApproval()){
            if($this->hasConfirmed()){
                return true;                
            }
        }
        else{
            foreach($this->teamMembers as $teamMember){
                if($teamMember->team->user->isConfirmed()){
                    return true;
                }
            }
        }
        return false;
    }
    function hasPaidForTeams(){
        foreach($this->teams as $team){
            if(!$team->isPaid()){
                return false;
            }
        }
        return true;
    }
    function getTotalAmountForOnline(){
        $category_id=Category::where('name','Workshop')->first()->id;
        $transactionFee = Payment::getTransactionFee();
        $totalAmount = 0;
        $amount=0;
        $workshop_amount=0;
        $event_amount=0;
        $fee=0;
        $events=$this->events()->where('category_id',2)->get();
        if($this->hasWorkshop())
        {    
            $workshops=$this->events()->where('category_id',1)->get(); 
            foreach($workshops as $workshop)
            {
                if($workshop->hasPgAmount())
                {    
                     if($this->isPg())
                     {
                         $amount+=$workshop->pg_amount;
                     }
                 }
                 else if($workshop->hasSaeAmount())
                 {
                     if($this->isSaeMemeber())
                     {
                         $amount+=$workshop->sae_amount;
                     }
                 }
                 else if($workshop->hasIeAmount())
                 {
                     if($this->isIeMemeber())
                     {
                         $amount+=$workshop->ie_amount;
                     }
                 }
                 else if($workshop->hasIeteAmount())
                 {
                     if($this->isIeteMemeber())
                     {
                         $amount+=$workshop->iete_amount;
                     }
                 }
                 else
                 {
                     $amount+=$workshop->amount;
                 } 
            }
            $workshop_amount+=$amount;
        }
            
       if($this->hasParticipating())
       {
           $event_amount+=Payment::getEventAmount();
       }
       if($workshop_amount!=0)
       {
           $totalAmount+=$workshop_amount;
       }
       if($event_amount!=0)
       {
           $totalAmount+=$event_amount;
       }
       
        // Very Very important Add the transaction fee
        $totalAmount += $totalAmount*$transactionFee;
        return $totalAmount;
    }
    function getTotalAmount(){
        $category_id=Category::where('name','Workshop')->first()->id;
        $transactionFee = Payment::getTransactionFee();
        $totalAmount = 0;
        $amount=0;
        $event_amount=0;
        $workshop_amount=0;
        $event_amount=0;
        if($this->hasWorkshop())
        {    
            $workshops=$this->events()->where('category_id',1)->get(); 
            foreach($workshops as $workshop)
            {
               if($workshop->hasPgAmount())
               {    
                    if($this->isPg())
                    {
                        $amount+=$workshop->pg_amount;
                    }
                }
                else if($workshop->hasSaeAmount())
                {
                    if($this->isSaeMemeber())
                    {
                        $amount+=$workshop->sae_amount;
                    }
                }
                else if($workshop->hasIeAmount())
                {
                    if($this->isIeMemeber())
                    {
                        $amount+=$workshop->ie_amount;
                    }
                }
                elseif($workshop->hasIeteAmount())
                {
                    if($this->isIeteMemeber())
                    {
                        $amount+=$workshop->iete_amount;
                    }
                }
                else
                {
                    $amount+=$workshop->amount;
                } 
    
                
            }
            $workshop_amount+=$amount;
        }
        
       if($this->hasParticipating())
       {
           $event_amount+=Payment::getEventAmount();
       }
       if($workshop_amount!=0)
       {
           $totalAmount+=$workshop_amount;
       }
       if($event_amount!=0)
       {
           $totalAmount+=$event_amount;
       }
  
        return $totalAmount;
    }
    function getTotalAmountPaid(){
        $transactionFee = Payment::getTransactionFee();
        $totalAmount = 0;
        $amount = Payment::getEventAmount();
        foreach($this->payments as $payment){
            $totalAmount += $amount;
        }
        // Very Very important Add the transaction fee
        $totalAmount += $totalAmount*$transactionFee;
        return $totalAmount;
    }
    function doPayment($txnid){
        foreach($this->getUsersToPay() as $user){
           
            $payment->user_id = $user->id;
            $payment->transaction_id = $txnid;
            $user->payment()->save($payment);
        }
    }
    function doPaymentDD($filename){
            foreach($this->getUsersToPay() as $user){
                $payment = new Payment();
               
                $payment->user_id = $user->id;
                $payment->file_name = $filename;
                $payment->payment_status='notpaid';
                $payment->status='nack';
                $payment->amount=$this->getTotalAmount();
                $user->payment()->save($payment);
            }
        

    }
    function getTransactionId(){
        $uid = "GM18_" . $this->id . '_' . strrev(time());
        $uid = substr($uid, 0,25);
        return $uid;
    }
    function getAccomodationAmount(){
        $amount = Payment::getAccomodationAmount();
        $totalAmount = $amount + $amount * Payment::getTransactionFee();
        return .5;
    }
    function getHash($amount){
        $key = Payment::getPaymentKey();
        $salt = Payment::getPaymentSalt();
        $txnid = $this->getTransactionId();
        $productInfo = Payment::getProductInfo();
        $firstname = $this->first_name;
        $email = $this->email;
        $hashFormat = "$key|$txnid|$amount|$productInfo|$firstname|$email|||||||||||$salt";
        $hash = strtolower(hash('sha512', $hashFormat));
        return $hash;
    }
    // Check if the user has the given role
   function hasRole($role_name){
        if($this->roles()->where('role_name', $role_name)->count()){
            return true;
        }
        return false;
   }
    function GMId(){
        return 'GM' . $this->id;
    }
    function hasActivated(){
        if($this->activated == true){
            return true;
        }
        else{
            return false;
        }
    }
    function isRejected(){
        if($this->payment && $this->payment->status == 'nack'){
            return true;
        }
        return false;
    }
    function hasOnlyTeamEvents(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() != 0){
            return true;
        }
        else{
            return false;
        }
    }
    function hasSureEvents(){
        if($this->events()->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() != 0){
            foreach($this->teamMembers as $teamMember){
                if($teamMember->team->user->hasConfirmed()){
                    return true;
                }
            }
            return false;
        }
        else{
            return true;
        }
    }
    static function search($term){
        $college_ids = College::where('name', 'LIKE', $term)->pluck('id')->toArray();        
        $users = self::where('id', 'LIKE', $term)->orWhere('first_name', 'LIKE', $term)->orWhere('email', 'LIKE', $term)->orWhere('gender', 'LIKE', $term)->orWhere('mobile', 'LIKE', $term)->orWhereIn('college_id', $college_ids);  

        return $users;
    }
    function hasUploadedTicket(){
        if($this->hasConfirmed()){
            if(!empty($this->confirmation->file_name)){
                return true;
            }
        }
        return false;
    }
    function hasWorkshop(){
        $workshop=Category::where('name','WORKSHOP')->first();
        if($this->events()->where('category_id',$workshop->id)->count() !=0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function hasEvents(){
        $event=Category::where('name','EVENTS')->first();
        if($this->events()->where('category_id',$event->id)->count() !=0 )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function hasRegisteredBoth()
    {
        if($this->hasWorkshop())
        {
            if($this->hasParticipating())
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    function isPg(){
        if($this->level_of_study == 'PG')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function isSaeMemeber()
    {
        if($this->sae_id!=NULL)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function isIeMemeber()
    {
        if($this->ie_id!=NULL)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function isIeteMemeber()
    {
        if($this->iete_id!=NULL)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function PresentInTeam()
    {
        if(TeamMember::find($this->id))
        {
            return true;
        }
        else
        {
            return false;

        }
    }
    function hasParticipating()
    {
        if($this->events()->where('category_id',2)->count() == 0 && $this->teams()->count() == 0 && $this->teamMembers()->count() == 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
  
}
