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
                <tr>
                <th>Mode Of Payment</th>
                @if($user->payment)
                   <td> {{$user->payment->mode_of_payment}}</td>
                    @if($user->payment->mode_of_payment=='dd')
                    <a href="/uploads/Event/demand_draft/{{$user->payment->file_name}}" class= "right" target="_blank">View Ticket <i class="fa fa-eye"></i></a></td>
                    @endif
                @endif   
            </td>
    
             @if($user->payment)
                    <tr>
                        <th>Payment Request</th>
                        <td>
                            @if($user->payment->status == 'ack')
                                <span class="green-text">Accepted</span>
                            @elseif($user->payment->status == 'nack')
                                <span class="red-text">Rejected</span>    
                            @else
                                Yet to be acknowledged
                            @endif
                        </td>
                    </tr>
                @endif
            </td>
        </tr>
        @if($user->payment && $user->payment->status == 'ack')
                    <tr>
                        <th>Payment Status</th>
                        <td>
                            @if($user->payment->payment_status =='paid')
                                <span class="green-text">Paid</span>
                            @else
                                <span class="red-text">Not Paid</span>                                
                            @endif
                        </td>
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
