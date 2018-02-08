@extends('layouts.main')
@section('content')

@foreach($events as $event)
<div class="section white">
  <div class="row">
    <div class="col m3 s12">
        <div class="card">
            <div class="card-image">
                <img src="{{ url($event->getImageUrl()) }}">
            </div>
        </div>
    </div> <div class="col m8 s12">
    <h4 class="header">{{ $event->title }}</h4>
    @foreach($event->getDescriptionList() as $rul)
                <p>{!! $rul !!}<p>
            @endforeach
    <h5 class="header">Rules</h5>
    <ul>
    @foreach($event->getRulesList() as $rule)
            @if($rule=="DETAILS ABOUT THE ABSTRACT")
                <h5 class="header">{{$rule}}</h5>
                <?php continue; ?>
            @endif
           <li>{!! $rule !!}</li>
            @endforeach  
    </ul>
    <p><i class="fa fa-calendar"></i> {{ $event->getDate() }} &nbsp  &nbsp  &nbsp 
   <i class="fa fa-clock-o"></i> {{ $event->getStartTime() }} to {{ $event->getEndTime() }}</p>
  
 
   @if($event->prelims && $event->finals)
   <p><i class="fa fa-clock-o"></i>PRELIMS {{$event->getPrelimsTime()}} &nbsp  &nbsp  &nbsp
   <i class="fa fa-clock-o"></i>FINALS {{$event->getFinalsTime()}}</p>
   @endif
        @if(Auth::check())
            @if(Auth::user()->type == 'student')
                {{-- Check if user has confirmed if so dont show any register buttons   --}}            
                @if(!Auth::user()->hasRegisteredEvent($event->id) && !Auth::user()->hasConfirmed())
                    @if(!$event->isGroupEvent())
                        {{ link_to('#', 'RESERVE MY SEAT', ['class' => 'btn waves-effect waves-light green btn-register-event pulse', 'data-event' => $event->id]) }}
                    @else
                        {{ link_to_route('pages.registerteam', 'RESERVE A SEAT FOR MY TEAM', ['event_id' => $event->id], ['class' => 'btn waves-effect waves-light green pulse btn-registerteam-event', 'data-event' => $event->id]) }}
                    @endif
                @else
                    {{ link_to_route('user_pages.dashboard', 'GOTO DASHBOARD', null,  ['class' => 'btn waves-effect waves-light green pulse']) }}
                @endif
            @endif
        @else
            {{ link_to_route('auth.login', 'LOGIN TO RESERVE YOUR SEAT', null,  ['class' => 'btn waves-effect waves-light red pulse']) }}
        @endif
        </div>
    </div>
</div>
<div class="parallax-container">
      <div class="parallax">{!! HTML::image('images/3.jpeg') !!}
      </div>
</div>      
    
    
@endforeach
<script>
    $(function(){
        $('.btn-register-event').on('click', function(evt){
            evt.preventDefault();
            var eventId = $(this).attr('data-event');
            var url = eventId + "/" + "register";
            var registerLink = $(this);
            $.ajax({
                url: url,
                success: function(res){
                    if(res.error){
                        Materialize.toast(res.message, 8000);                        
                    }
                    else{
                        registerLink.text("Go to Dashboard");                        
                        registerLink.attr('href', "{{ route('user_pages.dashboard') }}");
                        registerLink.unbind("click");
                        Materialize.toast('Event added to dashboard!', 8000);
                    }
                },
                error: function(){
                    Materialize.toast('Something went wrong!, please try again', 8000);
                }
            });
        });
    });
</script>

@endsection