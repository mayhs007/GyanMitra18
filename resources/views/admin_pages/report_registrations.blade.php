@extends('layouts.adminreport')

@section('content')

<div class="row">
    <div class="col s12">
        <p class="flow-text">{{ $users_count }} results <i class="fa fa-users"></i></p>                
        @if($users->count() == 0)
            <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>            
        @else
            <table>
                <thead>
                    <tr>
                        <th>
                            GM ID
                        </th>
                        <th>
                            First Name
                        </th>
                        <th>
                            Last Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            College
                        </th>
                        <th>
                            Gender
                        </th>
                        <th>
                            Mobile
                        </th>
                        @if($workshop_check)
                        <th>
                            Workshop
                        </th>
                        @endif
                        @if($event_check)
                        <th>
                            Event
                        </th>
                        <th>
                            Team Event
                        </th>
                        @endif
                        <th>
                            SAE 
                        </th>
                        <th>
                            IE 
                        </th>
                        <th>
                            IETE 
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Payment
                        </th>
                        <th>
                            Mode
                        </th>
                        <th>
                            AMOUNT
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->GMId() }}</td>
                            <td>{{ $user->first_name }} </td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->college->name }}</td>
                            <td>{{ $user->gender }}</td>                            
                            <td>{{ $user->mobile }}</td>
                            @if($workshop_check)
                                @if($user->hasWorkshop())
                                    <td>
                                    @foreach($user->events->where('category_id',1) as $workshops)
                                        {{$workshops->title}}<br>
                                    @endforeach
                                    </td>
                                @else
                                    <td class="center">-</td>
                                @endif
                            @endif
                            @if($event_check)
                                @if($user->hasEvents())
                                    <td>
                                    @foreach($user->events->where('category_id',2) as $events)
                                        {{$events->title}}<br>
                                    @endforeach
                                    </td>
                                @else
                                    <td class="center">-</td>
                                @endif 
                                @if($user->TeamEvents())
                                    <td>
                                    @foreach($user->events as $event)
                                        @if($user->isTeamLeader($event->id))
                                            {{$event->title}}<br>
                                        @elseif($user->isTeamMember($event->id))
                                            {{$event->title}}<br>
                                        @endif
                                    @endforeach 
                                    s
                                    </td>
                                @else
                                    <td class="center">-</td>
                                @endif
                            @endif
                            @if($user->isSaeMemeber())
                                <td>{{ $user->sae_id }}</td>
                            @else
                                <td class="center">-</td>
                            @endif
                            @if($user->isIeMemeber())
                                <td>{{ $user->sae_id }}</td>
                            @else
                                <td class="center">-</td>
                            @endif
                            @if($user->isIeteMemeber())
                                <td>{{ $user->sae_id }}</td>
                            @else
                                <td class="center">-</td>
                            @endif    
                            <td>
                                @if($user->hasConfirmed())
                                    Confirmed
                                @else
                                    Not yet cofirmed                                    
                                @endif
                            </td>    
                            <td>
                                {{ $user->hasPaid()?'Paid': 'Not Paid' }}
                            </td>
                                @if($user->hasConfirmed())
                                    <td>{{ $user->payment->mode_of_payment }}</td>
                                @else
                                    <td class="center">-</td>
                                @endif
                                @if($user->hasPaid())
                                <td>{{$user->payment->amount}}</td>
                                @else
                                <td class="center">-</td>
                                @endif 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
<div class="row">
    <div class="col s12">
        {{ $users->appends(Request::capture()->except('page'))->render() }}        
    </div>
</div>

@endsection