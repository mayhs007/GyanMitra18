<ul class="collection with-header">
    <li class="collection-header"><h5>Student Details</h5></li>
    <li class="collection-item">
        <table>
            <tbody>
                <tr>
                    <th>GyanMitra18</th>
                    <td>{{ $user->GMId() }}</td>
                </tr>
                <tr>
                    <th>
                        Attendence
                    </th>
                    <td>
                        <div class="switch">
                            <label>
                                Absent
                                <input class="attendance" data-id="{{ $user->id }}" {{ $user->present? "checked":'' }} type="checkbox">
                                <span class="lever"></span>
                                Present
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $user->first_name }} {{$user->last_name}}</td>
                </tr>
                <tr>
                    <th>College</th>
                    <td>{{ $user->college->getQualifiedName() }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ $user->gender }}</td>
                </tr>
                <tr>
                    <th>Mobile</th>
                    <td>{{ $user->mobile }}</td>
                </tr>
                <tr>
                    <th>Registration Confimation</th>
                    <td>
                        @if($user->hasConfirmed())
                            <span class="green-text">Confirmed</span>
                        @else
                            <span class="red-text">Not Confimed</span>
                        @endif
                    </td>
                </tr>
                @if($user->hasPaid())
                    <tr>
                        <th>Mode Of Payment</th>
                        <td>{{ $user->payment->mode_of_payment}} 
                        <a href="/uploads/demand_draft/{{ $user->payment->file_name }}" class= "right" target="_blank">View Ticket <i class="fa fa-eye"></i></a></td>
                    </tr>
                @endif
                <tr>
                    <th>Payment Status</th>
                    <td>
                        @if($user->payment->mode_of_payment == 'dd')
                            @if($user->hasConfirmedDD())
                             <span class="green-text">Payment Has Been Checked</span>
                            @else
                            <span class="red-text">Payment Not Checked</span>
                            @endif
                        @else
                            @if($user->hasPaid())
                                <span class="green-text">Paid</span>
                            @else
                                <span class="red-text">Not Paid</span>
                            @endif
                        @endif
                        
                    </td>
                </tr>
                @if($user->hasPaid())
                    <tr>
                        <th>Paid By</th>
                        <td>{{ $user->payment->paidBy->first_name }} [{{ $user->payment->paidBy->email }}]</td>
                    </tr>
                @endif
                @if($user->accomodation)
                    <tr>
                        <th>Accomodation Request</th>
                        <td>
                            @if($user->accomodation->acc_status == 'ack')
                                <span class="green-text">Accepted</span>
                            @elseif($user->accomodation->acc_status == 'nack')
                                <span class="red-text">Rejected</span>    
                            @else
                                Yet to be acknowledged
                            @endif
                        </td>
                    </tr>
                @endif
                @if($user->accomodation && $user->accomodation->status == 'ack')
                    <tr>
                        <th>Accomodation Payment Status</th>
                        <td>
                            @if($user->accomodation->paid)
                                <span class="green-text">Paid</span>
                            @else
                                <span class="red-text">Not Paid</span>                                
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </li>
</ul>
@if($user->events()->count())
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>Events Details</h5>                            
        </li>
        @foreach($user->events as $event)
            <span class="new badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($event->id) }}</span> 
            <span class="new badge green" data-badge-caption="Total Confirmed">{{   $event->noOfConfirmedRegistration() }}</span>
            <li class="collection-item">
                {{ $event->title }}
            </li>
        @endforeach
    </ul>
@endif
@if($user->teams()->count() > 0 || $user->teamMembers()->count() > 0)
    <ul class="collection with-header">
        <li class="collection-header">
            <h5>Teams Details</h5>
        </li>
        @foreach($user->teams as $team)
            <li class="collection-item">
                <span class="new badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($team->events->first()->id) }}</span> 
                <span class="new badge green" data-badge-caption="Total Confirmed">{{ $team->events->first()->noOfConfirmedRegistration() }}</span>
                <p>
                    <strong>{{ $team->events->first()->title }}</strong>                         
                </p>
                <p>
                    @include('partials.team_details', ['team' => $team])
                </p>
            </li>
        @endforeach
        @foreach($user->teamMembers as $teamMember)
            <li class="collection-item">
                <span class="new badge blue" data-badge-caption="From Same college">{{ $user->college->noOfParticipantsForEvent($teamMember->team->events->first()->id) }}</span> 
                <span class="new badge green" data-badge-caption="Total Confirmed">{{ $teamMember->team->events->first()->noOfConfirmedRegistration() }}</span>
                <p>
                    <strong>{{ $teamMember->team->events->first()->title }}</strong>                         
                </p>
                <p>
                    @include('partials.team_details', ['team' => $teamMember->team])
                </p>
            </li>
        @endforeach
    </ul>
@endif