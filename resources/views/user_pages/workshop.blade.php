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
        </div>
        <div class="col m9 s12">
            <h4 class="header">{{ $event->title }}</h4>
            @foreach($event->getDescriptionList() as $resource)
                <p>  {!! $resource !!}</p>
            @endforeach 
            <p><i class="fa fa-calendar"></i> {{ $event->getDate() }} &nbsp &nbsp &nbsp &nbsp
            <i class="fa fa-clock-o"></i> {{ $event->getStartTime() }} to {{ $event->getEndTime() }}</p>
            <p><i class="fa fa-map-marker"></i> {{$event->venue}}</p>
            <p>NON-MEMBER:  <i class="fa fa-inr"></i>{{$event->amount}}./-&nbsp &nbsp
            @if($event->hasSaeAmount())
                 SAE MEMEBER:  <i class="fa fa-inr"></i> {{ $event->sae_amount}}./-&nbsp &nbsp
            @endif
            @if($event->hasIeAmount())
                 IE MEMEBER:   <i class="fa fa-inr"></i> {{ $event->ie_amount}}./-
            @endif
            </p>
            <i class="fa fa-graduation-cap"></i>
            @foreach($event->getResourcePersonList() as $resource)
                    {!! $resource !!}
            @endforeach  
            <br>
            <br>
            @if(Auth::check())
                @if(Auth::user()->hasRegistered($event->id))
                    <a href="{{route('user_pages.dashboard')}}"  class="waves-effect waves-light btn green pulse">Go To Dashboard</a>
                @else
                    <a href="#"  data-event="{{ $event->id }}" class="waves-effect waves-light btn btn-register-event green pulse">Register</a>
                @endif
            @else
                <a href="{{route('auth.login')}}" class="waves-effect waves-light btn  red pulse">LOGIN TO REGISTER</a>
            @endif
        </div>
    </div>
</div>
<div class="parallax-container">
      <div class="parallax"><img src="/images/3.jpeg"></div>
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