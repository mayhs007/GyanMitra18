<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;
use App\Department;
use App\User;
use App\Event;
use App\Category;
use Session;

class EventsController extends Controller
{
 
    public function index()
    {
        //
        $events = Event::paginate(10);
        return view('admin_pages.events.index')->with('events', $events);
    }


    public function create()
    {
        $event = new Event();
        $event->max_members = 1;
        $event->min_members = 1;
        $event->allow_gender_mixing = 1;
        $categories = Category::pluck('name', 'id');
        $departments = Department::pluck('name','id');
        $organizers = "";
        return view('admin_pages.events.create')->with('event', $event)->with('categories', $categories)->with('departments', $departments)->with('organizers', $organizers);
    }


    public function store(Request $request)
    {
        $input = $request->all();
        // Upload file
        if(!empty($request->file('event_image'))){
            $filename = $request->file('event_image')->getClientOriginalName();
            $request->file('event_image')->move('images/events',  $filename);
            // Set image name
            $input['image_name'] = $filename;    
        }
        // Create event record    
        $event = Event::create($input);
        // Add organizers
        $organizerEmails = explode(",", $input['organizers']);
        foreach($organizerEmails as $organizerEmail){
            $organizer = User::where('email', $organizerEmail)->first();
            $event->organizers()->save($organizer);
        }
        // Set flash message
        Session::flash('success', 'The event was created successfully!');
        return redirect()->route('admin::events.create');
    }

  
    public function show($id)
    {
        //
        
    }


    public function edit($id)
    {
        //
        $event = Event::findOrFail($id);
        $categories = Category::pluck('name', 'id');
        $organizers = $event->getOrganizersList(); 
        $departments = Department::pluck('name','id');       
        return view('admin_pages.events.edit')->with('event', $event)->with('categories', $categories)->with('departments', $departments)->with('organizers', $organizers);
    }

 
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        // Get the event
        $event = Event::findOrFail($id);
        // Upload file
        if($request->file('event_image')){
            $filename = $request->file('event_image')->getClientOriginalName();
            $request->file('event_image')->move('images/events',  $filename);
            // Set image name
            $input['image_name'] = $filename;    
        }
        // Update event record    
        $event->update($input);
        // Update organizers
        $event->organizers()->detach();
        $organizerEmails = explode(",", $input['organizers']);
        foreach($organizerEmails as $organizerEmail){
            $organizer = User::where('email', $organizerEmail)->first();
            $event->organizers()->save($organizer);
        }
        // $event->organizers()->save();
        // Set flash message
        Session::flash('success', 'The event was edited successfully!');
        return redirect()->route('admin::events.index');
    }


    public function destroy($id)
    {
        //
        Event::destroy($id);
        Session::flash('success', 'The event was deleted successfully!');
        return redirect()->route('admin::events.index');
    }
}
