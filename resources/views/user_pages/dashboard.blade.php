@extends('layouts.auth')
@section('content')
@if(Auth::check())
    @if(Auth::User()->events()->count() || Auth::user()->teamEvents()->count())
        <div class="container">
        <div class="row">
            @foreach($events as $event)
            
                <div class="col m6 s12">
                    @include('partials.events', ['event' => $event])
                </div>
            @endforeach
            @foreach($teamEvents as $event)
                <div class="col m6 s12">
                    @include('partials.events', ['event' => $event])
                </div>
            @endforeach
        </div>
        </div>
    @else
        <h1 class="header">You have not yet regitser a event</h1>
    @endif
@else
    <h1> hello</h1>
@endif
<div class="container">
 <div class="row">
    <ul class="stepper">
        <li class="step active">
            <div class="step-title waves-effect waves-dark">Confirm Registration</div>
            <div class="step-content">
                <p>
                    <ul>
                        <li>
                            <p>
                                <i class="fa {{ $user->isParticipating()?'fa-check':'fa-times' }}"></i> Participate in atleast one single or team event or workshop
                            </p>
                            @if($user->hasOnlyTeamEvents())
                                <p>
                                    <i class="fa {{ $user->hasSureEvents()?'fa-check':'fa-times' }}"></i> Atleast one of your team leaders has confirmed your participation in their team
                            </p>
                            @endif

                        </li>
                    </ul>
                </p>
                @if($user->isParticipating())
                    <p class="red-text">After clicking on confirm and generate ticket you wont be able to further add or remove any other events</p>
                @endif
                <a class="btn waves-effect waves-light green modal-trigger {{ ($user->hasConfirmed()|| !$user->canConfirm())?'disabled':'' }}" href="#modal-confirm">Confirm and Procced to Payment</a>
            </div>
        </li>
        <li class="step {{ $user->hasConfirmed()?'active':'' }}">
            <div class="step-title waves-effect waves-dark">Payment Mode</div>
                <div class="step-content">
                @if(!$user->hasPaid())
                    @if($user->hasTeams())
                        <i class="fa {{ $user->hasConfirmedTeams()?'fa-check':'fa-times' }}"></i> All your team members have confirmed their registration
                    @endif
                    <div class="container">
                        <p>
                            <input name="mode_of_payment" type="radio" id="online" />
                            <label for="online">ONLINE PAYMENT</label>
                            <input name="mode_of_payment" type="radio" id="DD" />
                            <label for="DD">DEMAND DRAFT</label>
                        </p>
                    </div>       
                    <div id="payu">
                       
                            <p><strong>You will be paying for the following!</strong></p>
                            <table class="bordered highlight responsive-table">     
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registration Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Get all users to pay   --}}
                                    @foreach($user->getUsersToPay() as $userToPay)
                                        <tr>
                                            <td>{{ $userToPay->first_name }}  {{ $userToPay->last_name }}</td>
                                            <td>{{ $userToPay->email }}</td>
                                            <td>
                                                @if($userToPay->hasConfirmed())
                                                    <span class="green-text">Confirmed</span>
                                                @else
                                                    <span class="red-text">Not Confirmed</span>
                                                @endif
                                             </td>    
                                         </tr>
                                    @endforeach
                                         <tr>
                                            <td><td>TOTAL AMOUNT:- </td></td>
                                            <td><td><i class="fa fa-inr"></i>{{ $user->getTotalAmount() }}</td></td>
                                        </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total Amount (Includes 4% transaction fee)</th>
                                        <th><i class="fa fa-inr"></i> {{ $user->getTotalAmountForOnline() }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                        @if($user->hasConfirmedTeams())
                            @if($user->hasConfirmed())
                                <button type="button" onclick="$('#frm-payment').submit()" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                            @else
                                <button type="submit"  class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>                       
                            @endif
                            @else
                                <button type="submit"  class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                        @endif
                        </div>
                        <div id="draft">
                        <p><strong>You will be paying for the following!</strong></p>
                            <table class="bordered highlight responsive-table">     
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registration Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Get all users to pay   --}}
                                    @foreach($user->getUsersToPay() as $userToPay)
                                        <tr>
                                            <td>{{ $userToPay->first_name }}  {{ $userToPay->last_name }}</td>
                                            <td>{{ $userToPay->email }}</td>
                                            <td>
                                                @if($userToPay->hasConfirmed())
                                                    <span class="green-text">Confirmed</span>
                                                @else
                                                    <span class="red-text">Not Confirmed</span>
                                                @endif
                                             </td>    
                                         </tr>
                                    @endforeach
                                         <tr>
                                            <td><td>TOTAL AMOUNT:- </td></td>
                                            <td><td><i class="fa fa-inr"></i>{{ $user->getTotalAmount() }}</td></td>
                                        </tr>
                                </tbody>
                                <tfoot>
                                   <tr>
                                       <th>DD DETAILS</th>
                                       <th>IN FAVOUR OF "THE PRINCIPAL,MEPCO SCHLENK ENGINEERING COLLEGE"</th>
                                       <th>PAYABLE AT SIVAKSI</th>
                                   </tr>
                                </tfoot>
                            </table>
                            @if($user->hasConfirmedTeams())
                            <p>
                                @include('partials.error')                        
                                    {!! Form::open(['url' => route('user_pages.ticket.upload'), 'files' => true, 'id' => 'form-upload-ticket', 'style' => 'display:inline']) !!}
                                    {!! Form::file('demand_draft', ['class' => 'hide', 'id' => 'file-ticket']) !!}
                                    {!! Form::close() !!}
                                    <button type="button" class="btn waves-effect waves-light green {{ $user->hasConfirmed()?'':'disabled' }}" id="btn-upload-ticket">Upload PhotoCopy Of DD</button>
                            </p>
                            @endif
                        </div>
                    @else
                        @if($user->payment->payment_status=='paid')
                        <p class="green-text"><i class="fa fa-check"></i> Hurray! your payment is confirmed, we are excited to see you at GyanMitra18</p>
                        <p>
                        {{ link_to_route('user_pages.payment.reciept', 'Download Payment Reciept', null, ['class' => 'waves-effect waves-light btn green']) }}
                        </p>
                        @else
                            <p> WAIT YOUR PAYMENT WILL VERIFIED BY US AND THEN YOU CAN DOWNLOAD THE RECPIET</p>
                        @endif
                    @endif
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="modal" id="modal-confirm">
    <div class="modal-content">
        <h4>Are you sure?</h4>
        <p>
            After confimration you wont be able to add or remove events from your wishlist!
        </p>
    </div>
    <div class="modal-footer">
        <a class="btn-flat waves-effect waves-red modal-action modal-close">No not now!</a>
        {{ link_to_route('user_pages.confirm', 'Got it!', null, ['class' => 'btn-flat waves-effect waves-green modal-action modal-close']) }}        
    </div>
</div>
@if($user->hasConfirmedTeams())
    <form action="{{ env('PAYU_URL') }}" id="frm-payment" method="post">
        <input type="hidden" name="key" value="{{ App\Payment::getPaymentKey() }}">
        <input type="hidden" name="txnid" value="{{ $user->getTransactionId() }}">    
        <input type="hidden" name="amount" value="{{ $user->getTotalAmountForOnline() }}">
        <input type="hidden" name="productinfo" value="{{ App\Payment::getProductInfo() }}">
        <input type="hidden" name="firstname" value="{{ $user->first_name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="hidden" name="phone" value="{{ $user->mobile }}">            
        <input type="hidden" name="surl" value="{{ route('user_pages.payment.success') }}">   
        <input type="hidden" name="furl" value="{{ route('user_pages.payment.failure') }}">
        <input type="hidden" name="hash" value="{{ $user->getHash($user->getTotalAmountForOnline()) }}">
    </form>
@endif

<footer class="page-footer blue-grey darken-3">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">CONTACT US</h5>
                <p class="grey-text text-lighten-4">ANY QUERIES REGARDING PAYMENT PROCESS CONTACT US 24X7</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">MAil id</h5>
                <ul>
                  <li>gyanmitra18@mepcoeng.ac.in</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © 2018 MEPCO SCHLENK ENGG COLLEGE
            </div>
          </div>
        </footer>
<script>
    $('#btn-upload-ticket').on('click', function(){
        $('#file-ticket').trigger('click');
    });
    $('#file-ticket').on('change', function(){
        $('#form-upload-ticket').submit();
    });
</script>

<script>
$(function(){
    $('#draft').hide();
    $('#payu').hide();
   $('.stepper').activateStepper();
   $('#online').click(function(){
      $('#payu').show();
      $('#draft').hide();
   });
   $('#DD').click(function(){
      $('#draft').show();
      $('#payu').hide();
   });
});
</script>

@endsection

