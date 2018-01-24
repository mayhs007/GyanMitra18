@extends('layouts.main')
@section('content')
<div class="section  white">
    <div class="row container">
      <h2 class="header">DOMAIN</h2>
      <p class="grey-text text-darken-3 lighten-3">SELECT YOUR DOMAIN FOR WORKSHOP/EVENTS
    </div>
</div>
<div class="parallax-container">
  <div class="parallax"><img src="image/21.png"></div>
</div>
<div class="section grey lighten-3">
    <div class="row container">
      <div class="row">
      @foreach($departments as $department)          
        <div class="col s12 m4">  
          <div class="card sticky-action">
            <div class="card-image waves-effect waves-block waves-light">
              <img class="activator" src="{{ url($department->getImageUrl()) }}" >
            </div>
            <div class="card-content">
              <span class="card-title activator grey-text text-darken-4">{{$department->original_name}}<i class="material-icons right">more_vert</i></span>
            </div>
            <div class="card-action">
            @if($department->name=='COMMON TO ALL')
             
            @else
            <a href="{{route('user_pages.workshop', ['department_id' => $department->id])}}">WORKSHOP</a>
            @endif
              <a href="{{route('user_pages.events',['department_id' => $department->id]) }}" >EVENTS</a> 
              
            </div>
            <div class="card-reveal">
              <span class="card-title grey-text text-darken-4">{{$department->original_name}}<i class="material-icons right">close</i></span>
              @if($department->name=='COMMON TO ALL')
              <p>Number of Events:{{$department->events()->where('category_id',2)->count()}}</p>
              @else
              <p>Number of Workshop:{{$department->events()->where('category_id',1)->count()}}</p>
              <p>Number of Events:{{$department->events()->where('category_id',2)->count()}}</p>
              @endif
            </div>
          </div>
        </div>
      @endforeach
      </div>
    </div>
  </div>
</div>
@endsection


