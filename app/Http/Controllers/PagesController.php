<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\Registration;
use App\TeamMember;
use App\User;
use App\Department;
use App\Event;
use App\Confirmation;
use App\Accomodation;
use App\Rejection;
use Auth;
use Session;
use  App\Http\Requests\UploadTicketRequest;
use Illuminate\Support\Facades\Input;
use App\Payment;
use PDF;
class PagesController extends Controller
{
    
    function root(){
        $departments=Department::all();
        $events=Event::where('deparment_id');
        return view('user_pages.home');
    }
    function home(){
        
        $departments=Department::all();
        $events=Event::where('deparment_id');
        return view('user_pages.home')->with('departments',$departments)->with('events', $events);
    }
    function dashboard(){
        $events = Auth::user()->events;
        $user = Auth::user();
        $teamEvents = Auth::user()->teamEvents();        
        return view('user_pages.dashboard')->with('events', $events)->with('teamEvents', $teamEvents)->with('user', $user);
    }
    function help(){
        return view('user_pages.help');
    }
    function prizes(){
        $layout = Auth::check() && Auth::user()->type == 'admin' ? 'layouts.admin' : 'layouts.default';      
        $events = Event::all();
        return view('user_pages.prizes')->with('events', $events)->with('layout', $layout);
    }
    function offlineRegistration(){
        return view('user_pages.offline_registration');
    }
    function hospitality(){
        $user = Auth::user();
        return view('user_pages.hospitality')->with('user',$user);
    }
    function about(){
        return view('user_pages.about');
    }
    function event(){
        $departments=Department::all();
        $events=Event::where('deparment_id');
        return view('user_pages.event')->with('departments',$departments)->with('events', $events);
    }
    function events($department_id){
        $events = Event::all()->where('department_id',$department_id)->whereIn('category_id',2);
        return view('user_pages.events')->with('events', $events);
    }
    function workshop($department_id)
    {
        $events = Event::all()->where('department_id',$department_id)->whereIn('category_id',1);
        return view('user_pages.workshop')->with('events', $events);
    }
    function requestHospitality()
    {
        $user = Auth::user();
        if($user->hasConfirmed())
        {
            if($user->hasRequestedAccomodation())
            {
                Session::flash('success', 'You have already requested accomodation');
            }
            else
            {
                $accomodation = new Accomodation();
                $user->Accomodation_Confirmation=true;
                $user->accomodation()->save($accomodation);
                $user->update();
                Session::flash('success', 'You have confirmed your hospitality!');           
            }
        }
        else
        {
            Session::flash('success', 'You need to confirm your registrations to request accomodation');
        }
        return redirect()->route('user_pages.hospitality');
    }
    function register($id)
    {
        $event = Event::find($id);
        $user = Auth::user();                                  
        $response = [];  
        $user->events()->save($event);
        $response['error'] = false;
        return response()->json($response);
    }
    function unregister($id)
    {
        $event = Event::find($id);
        $user = Auth::user();
        $event->users()->detach($user->id);        
        return  redirect()->route('user_pages.dashboard');
    }
    function createTeam($event_id)
    {
        $team = new Team();
        return view('admin_pages.teams.create')->with('team', $team);
    }
    function registerTeam(Request $request, $event_id)
    {
        $event  = Event::find($event_id);              
        $inputs = $request->all();
        $team  = new Team($inputs);
        $team->user_id = Auth::user()->id;
        $team->save();
        $team_members_emails = explode(',', $inputs['team_members']);
        $team_members_users = User::all()->whereIn('email', $team_members_emails);
        foreach($team_members_users as $team_member_user){
            $team_member = new TeamMember();
            
            $team_member->team_id = $team->id;
            $team_member->user_id = $team_member_user->id;
            $team->teamMembers()->save($team_member);
        }
        $team->events()->save($event);
        Session::flash('success', 'Team registered and event added to dashboard!');
        return redirect()->route('user_pages.events',['department_id'=>$event->department->id ]);
    }
    function unregisterTeam($event_id, $id){
        $team = Team::find($id);
        $event  = Event::find($event_id);                         
        $event->teams()->detach($id);
        $team->teamMembers()->delete();
        Team::destroy($team->id);
        return  redirect()->route('user_pages.dashboard');
    }
    function getCollegeMates($user_id){
        $user  = User::find($user_id);
        $userEmails = User::where('college_id', $user->college_id)->where('id', '<>', $user->id)->where('activated', false)->get(['email']);
        return response()->json($userEmails);
    }
    function confirm(){
        $user=Auth::user();
        $user->confirmation=true;
        $user->save();
        $payment=new Payment();
        $payment->user_id=$user->id;
        $payment->paid_by=0;
        $payment->payment_status='notpaid';
        $payment->status='nack';
        $payment->mode_of_payment='unknown';
        $payment->save();
        return redirect()->route('user_pages.dashboard');
    }
    function downloadTicket(){
        $user = Auth::user();
        $pdf = PDF::loadView('user_pages.ticket', [ 'user' => $user]);
        return $pdf->download('ticket.pdf');
    }

    function paymentSuccess(Request $request){
        $inputs = $request::all();
        if(strtolower($inputs['status']) == 'success' || strtolower($inputs['status']) == 'captured' ){
            $user = User::where('email', $inputs['email'])->first();
            if(isset($inputs['type']) && $inputs['type'] == 'accomodation'){
                $payment = Auth::user()->accomodation;
                $payment->acc_status='ack';
                $payment->acc_mode_of_payment='online';
                $payment->acc_payment_status='paid'; 
                $payment->acc_transaction_id =$inputs['txnid'];     
                $user->accomodation->save();
            }
            else{
                $payment = Auth::user()->payment;
                $payment->status='ack';
                $payment->mode_of_payment='online';
                $payment->payment_status='paid'; 
                $payment->transaction_id =$inputs['txnid'];     
                $user->doPayment($inputs['txnid']);
                $user->save();
                $this->rejectOtherRegistrations($user->id);
            }
            return view('user_pages.payment.success')->with('info', 'Your payment was successful!');
        }
        else{
            return view('user_pages.payment.failure')->with('info', 'Sorry! your transaction failed please try again!');
        }
    }
    function paymentFailure(Request $request){
        $errorInfo = "";     
        $inputs = $request->all();           
        if(isset($inputs['error']) && !empty($inputs['error'])){
            $errorInfo = $inputs['error'];
        }
        return view('user_pages.payment.failure')->with('info', 'Sorry! your transaction failed')->with('errorInfo', $errorInfo);      
    }
    function paymentReciept(){
        if(Auth::user()->hasPaid()){
            $user = Auth::user();
            $pdf = PDF::loadView('user_pages.payment.reciept', ['user' => $user],['registration' => $user]);
            return $pdf->download('payment-details.pdf');
        }
        else{
            Session::flash('success', 'You need to complete the payment first');
            return  redirect()->route('user_pages.dashboard');
        }
    }
    function uploadDemandDraftImage(UploadTicketRequest $request){
        // Check if the student can upload ticket for approval
        if(!Auth::user()->needApproval()){
            Session::flash('success', 'Sorry! Your Payment will be done by one of your team leaders');
            return redirect()->route('user_pages.dashboard');            
        }
        $extension = $request->file('demand_draft')->getClientOriginalExtension();
        $filename = 'demand_draft_' . Auth::user()->id . '.' . $extension;
        $payment = Auth::user()->payment;
        $request->file('demand_draft')->move('uploads/Event/demand_draft', $filename);
        $payment->file_name = $filename;
        $payment->status='nack';
        $payment->mode_of_payment='dd';
        $payment->payment_status='notpaid';
        $payment->user_id=Auth::User()->id;
        $payment->paid_by=Auth::User()->id;
        $payment->save();
        Auth::user()->doPaymentDD($filename);
        Session::flash('success', 'Your demand draft was uploaded');
        return redirect()->route('user_pages.dashboard');
    }
    function uploadAccomodationDemandDraftImage(UploadTicketRequest $request){
        // Check if the student can upload ticket for approval
        if(!Auth::user()->needApproval()){
            Session::flash('success', 'Sorry! Your Payment will be done by one of your team leaders');
            return redirect()->route('user_pages.dashboard');            
        }
        $extension = $request->file('demand_draft')->getClientOriginalExtension();
        $filename = 'demand_draft_acc_' . Auth::user()->id . '.' . $extension;
        $payment = Auth::user()->accomodation;
        $request->file('demand_draft')->move('uploads/Accomodation/demand_draft', $filename);
        $payment->acc_file_name = $filename;
        $payment->acc_status='nack';
        $payment->acc_mode_of_payment='dd';
        $payment->acc_payment_status='notpaid';
        $payment->user_id=Auth::User()->id;
        $payment->paid_by=Auth::User()->id;
        $payment->save();
        Auth::user()->doPaymentDD($filename);
        Session::flash('success', 'Your demand draft was uploaded');
        return redirect()->route('user_pages.dashboard');
    }
    
}
