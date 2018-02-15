<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GyanMitra18 Ticket</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .header{
            padding: 5px;
            text-align: center;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;                
        }
        body{
            border: 1px solid #000;
           
        }
        img{
            width:100%;
            height:100%;
        }
        
    </style>    
    </head>
    <body>
        <img src="image/header.jpg" class="img-responsive" alt="Header Image">
        <p class="header text-uppercase">Participation Details</p>
        <table>
            <tbody>
                <tr>
                    <th>GyanMitra18</th>
                    <td>{{ $user->GMId() }}</td>
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
                <tr>
                    <th>Amount Paid</th>
                    @if($user->payment->mode_of_payment == 'online')
                    <td>{{$user->getTotalAmountForOnline()}}</td>
                    @else
                       <td>{{$user->payment->amount}}</td>
                    @endif
                </tr>    

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
  

@if($registration->events->where('category_id',1)->count() > 0)
<p class="header text-uppercase">WORKSHOP</p>
        @foreach($registration->events->where('category_id',1) as $event)
            <li style="list-style: none">
                {{ $event->title }}
            </li>
        @endforeach
@endif
@if($registration->events->where('category_id',2)->count() > 0)
<p class="header text-uppercase">SOLO EVENTS</p>
        @foreach($registration->events->where('category_id',2) as $event)
            <li style="list-style: none">
                {{ $event->title }}
            </li>
        @endforeach
@endif
@if($registration->teamEvents()->count() > 0)
<p class="header text-uppercase">TEAM EVENTS</p>
    @foreach($registration->teamEvents() as $event)
    <li style="list-style: none">
                {{ $event->title }}
            </li>
    @endforeach
@endif
<hr>
     </body>
</html>