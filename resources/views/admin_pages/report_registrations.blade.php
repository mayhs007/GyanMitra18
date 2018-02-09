@extends('layouts.admin')

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
                        <th>
                            Workshop
                        </th>
                        <th>
                            Event
                        </th>
                        <th>
                            Team Event
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Payment
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
                            @if($user->hasWorkshop())
                                <td>
                                @foreach($user->events->where('category_id',1) as $workshops)
                                    {{$workshops->title}}<br>
                                @endforeach
                                </td>
                            @else
                                <td>-</td>
                            @endif  
                            @if($user->hasEvents())
                                <td>
                                @foreach($user->events->where('category_id',2) as $events)
                                    {{$events->title}}<br>
                                @endforeach
                                </td>
                            @else
                                <td>-</td>
                            @endif 
                            @if($user->hasTeams())
                                <td>
                                @foreach($user->TeamEvents() as $events)
                                    {{$events->title}}<br>
                                @endforeach
                                </td>
                            @else
                                <td>TeamMate</td>
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