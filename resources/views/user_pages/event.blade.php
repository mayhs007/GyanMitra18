@extends('layouts.main')
@section('content')
@foreach($departments as $department)
<div class="section white">
  <div class="row">
    <div class="col m4 s12">
      <div class="card">
            <div class="card-image">
                <img src="{{ url($department->getImageUrl()) }}">
                <div>
                  <ul class="divide">
                    <li class="workshop"><a href="{{route('user_pages.workshop', ['department_id' => $department->id])}}"class="work">WorkShop</a></li>
                    <li class="event"><a href="{{route('user_pages.events',['department_id' => $department->id]) }}"class="events">Events</a></li>
                  </ul>
                </div>
            </div>
      </div>
</div>
    <div class="col m6 s6 offset-m1 offset-s2">
        <h2 class="header">{{ $department->name }}</h2>
    
      <table class="highlight">
        <thead>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
        </thead>
      <tbody>
      @foreach($department->events as $event)  
      <tr>
            <td>{{ $event->title }}</td>
            <td><i class="fa fa-calendar"></i> {{ $event->getDate() }}</td>
            <td><i class="fa fa-clock-o"></i> {{ $event->getStartTime() }} to {{ $event->getEndTime() }}</td>
      </tr>
      @endforeach
      </tbody>
      </table>
    </div>
</div>
</div>
</div>

        
<div class="parallax-container">
      <div class="parallax"><img src="/images/a.jpg"></div>
</div>

@endforeach

@endsection


