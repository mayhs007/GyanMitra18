@extends('layouts.auth')
@section('content')
<div class="container">
<div class="row">
<div class="divider"></div>
  <div class="section">
    <h5>WORKSHOP SCHEDULE</h5>
</div>
<table class="highlight">
        <thead>
          <tr>
              <th>WORKSHOP NAME</th>
              <th>DOMAIN</th>
              <th>VENUE</th>
              <th>START TIME&END TIME</th>
              <th>AMOUNT</th>
          </tr>
        </thead>
        <tbody>
        @foreach($workshops as $workshop)
          <tr>
            <td>{{$workshop->title }}</td>
            <td>{{App\Department::all()->where('id',$workshop->category_id)->first()->name}}</td>
            <td>{{$workshop->venue }}</td>
            <td>{{$workshop->getStartTime() }}to{{$workshop->getEndTime()}}</td>
            <td>{{$workshop->amount }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
      
  <div class="divider"></div>
  <div class="section">
    <h5>EVENT SCHEDULE</h5>
</div>
      <table class="highlight">
        <thead>
          <tr>
              <th>EVENT NAME</th>
              <th>DOMAIN</th>
              <th>VENUE</th>
              <th>START TIME&END TIME</th>
              <th>AMOUNT</th>
          </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
          <tr>
            <td>{{$event->title }}</td>
            <td>{{App\Department::all()->where('id',$event->category_id)->first()->name}}</td>
            <td>{{$event->venue }}</td>
            <td>{{$event->getStartTime() }}to{{$workshop->getEndTime()}}</td>
            <td>{{$event->amount }}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
</div>
</div>
@endsection