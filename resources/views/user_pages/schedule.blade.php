@extends('layouts.auth')
@section('content')
<div class="container">
<div class="row">

  <div class="section">
    <h5>WORKSHOP SCHEDULE &nbsp(16-02-2018)</h5>
</div>
<div class="divider"></div>
<div class="divider"></div>
<table class="highlight responsive-table bordered centered">
        <thead>
          <tr>
              <th>WORKSHOP NAME</th>
              <th>DOMAIN</th>
              <th>VENUE</th>
              <th>START TIME</th>
              <th>END TIME</th>
              <th>AMOUNT</th>
              <th>IE MEMBER</th>
              <th>SAE MEMBER</th>
              <th>PG STUDENTS</th>
          </tr>
        </thead>
        <tbody>
        @foreach($workshops as $workshop)
          <tr>
            <td>{{$workshop->title }}</td>
            <td>{{App\Department::all()->where('id',$workshop->department_id)->first()->name}}</td>
            <td>{{$workshop->venue }}</td>
            <td>{{$workshop->getStartTime() }}</td>
            <td> {{$workshop->getEndTime()}}</td>
            <td>{{$workshop->amount }}</td>
            @if($workshop->hasSaeAmount())
              <td>{{$workshop->sae_amount }}</td>
            @else
              <td>-</td>
            @endif
            @if($workshop->hasIeAmount())
              <td>{{$workshop->ie_amount }}</td>
            @else
              <td>-</td>
            @endif
            @if($workshop->hasPgAmount())
              <td>{{$workshop->pg_amount }}</td>
            @else
              <td>-</td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
      

  <div class="section">
    <h5>EVENT SCHEDULE&nbsp(17-02-2018)</h5>
</div>
<div class="divider"></div>
<div class="divider"></div>
      <table class="highlight responsive-table bordered centered">
        <thead>
          <tr>
              <th>EVENT NAME</th>
              <th>DOMAIN</th>
              <th>VENUE</th>
              <th>START TIME&END TIME</th>
              
          </tr>
        </thead>
        <tbody>
        @foreach($events as $event)
          <tr>
            <td>{{$event->title }}</td>
            <td>{{App\Department::all()->where('id',$event->department_id)->first()->name}}</td>
            <td>{{$event->venue }}</td>
            <td>{{$event->getStartTime() }} to {{$workshop->getEndTime()}}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
</div>
</div>
@endsection