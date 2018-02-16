@extends('layouts.auth')
@section('content')
    <div class="container">
        @if(Auth::check())
            @if(App\Config::getConfig('Accomodation_registration_open'))
                <div class="container">
                    <div class="row">
                        <ul class="stepper">
                            <li class="step active">
                                <div class="step-title waves-effect waves-dark">RULES FOR HOSPITALITY</div>
                                <div class="step-content">
                                    <p>
                                        <ul>
                                            <li>
                                                YOU MUST HAVE PAID BOTH WORKSHOP AND EVENTS
                                            </li>
                                            <br>
                                            <li>
                                                GENERAL REFRESHMENT WILL BE PROVIDED ON 16/2/2018 MORNING ONWARDS
                                            </li>
                                            <br>
                                            <li>
                                                IT IS BASED ON FIRST COME FIRST SERVE
                                            </li>
                                            <br>
                                            <li>
                                               THE ACCOMODATION FEE IS :<i class="fa fa-inr">100</i> PER HEAD
                                            </li>
                                            <br>
                                            <li>
                                                ACCOMDATION IS AVAILABLE FOR ONE DAY ONLY
                                            </li>
                                        </ul>
                                    </p>
                                    @if(!$user->hasConfirmedAccomodation() && $user->hasPaid() )
                                        <a class="btn waves-effect waves-light green modal-trigger" href="#modal-confirm">CONFIRM AND PROCCED TO PAYMENT</a>
                                    @else
                                        <a class="btn waves-effect waves-light green modal-trigger disabled">CONFIRM AND PROCCED TO PAYMENT</a>
                                    @endif       
                                </div>
                            </li>
                            <li class="step {{ $user->hasConfirmedAccomodation()?'active':'' }}">
                                <div class="step-title waves-effect waves-dark">CONFIRM UR HOSPITALITY</div>
                                <div class="step-content">
                                    @if(!$user->hasPaidAccomodation())
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
                                                    <tr>
                                                        <td>{{ $user->first_name }}  {{ $user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                          @if($user->hasConfirmedAccomodation())
                                                            <span class="green-text">Confirmed</span>
                                                          @else
                                                            <span class="red-text">Not Confirmed</span>
                                                          @endif
                                                        </td>    
                                                    </tr>
                                                    <tr>
                                                        <td><td>TOTAL AMOUNT:- </td></td>
                                                        <td><td><i class="fa fa-inr"></i>{{ App\Payment::getAccomodationAmount() }}</td></td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3">Total Amount (Includes 4% transaction fee)</th>
                                                        <th><i class="fa fa-inr"></i> {{ $user->getAccomodationAmount() }}</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            @if($user->hasConfirmedAccomodation())
                                                <button type="button" onclick="$('#frm-payment').submit()" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
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
                                                    <tr>
                                                        <td>{{ $user->first_name }}  {{ $user->last_name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                        @if($user->hasConfirmedAccomodation())
                                                        <span class="green-text">Confirmed</span>
                                                        @else
                                                        <span class="red-text">Not Confirmed</span>
                                                        @endif
                                                        </td>    
                                                    </tr>
                                                    <tr>
                                                        <td><td>TOTAL AMOUNT:- </td></td>
                                                        <td><i class="fa fa-inr"></i>{{ App\Payment::getAccomodationAmount() }}</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th>DD DETAILS</th>
                                                    <th>IN FAVOUR OF "THE PRINCIPAL,MEPCO SCHLENK ENGINEERING COLLEGE"</th>
                                                    <th>PAYABLE AT SIVAKASI</th>
                                                </tr>
                                                <tr>
                                     
                                     <th>DD Should be sent to the following address:</th>
                                           <td class="center">  The Convener, <br>
                                             GYANMITRA'18,<br>
                                             Mepco Schlenk Engg. College,<br>
                                             Sivakasi - 626 005.<br>
                                             Virudhunagar (Dist.)<br>
                                             Tamilnadu</td>
                                         </tr>
                                            </tfoot>
                                            </table>
                                            @if($user->hasConfirmedAccomodation())
                                            <p>
                                                @include('partials.error')                        
                                                    {!! Form::open(['url' => route('user_pages.ticket.uploadaccomodation'), 'files' => true, 'id' => 'form-upload-ticket', 'style' => 'display:inline']) !!}
                                                    {!! Form::file('demand_draft', ['class' => 'hide', 'id' => 'file-ticket']) !!}
                                                    {!! Form::close() !!}
                                                <button type="button" class="btn waves-effect waves-light green {{ $user->hasConfirmed()?'':'disabled' }}" id="btn-upload-ticket">Upload Ticket</button>
                                            </p>
                                            @endif
                                        </div>
                                    @else
                                        @if($user->accomodation->acc_payment_status=='paid')
                                            <p class="green-text"><i class="fa fa-check"></i> Hurray! your payment is confirmed, we are excited to see you at GyanMitra18</p>
                                            <p>
                                            {{ link_to_route('user_pages.payment.reciept', 'Download Payment Reciept', null, ['class' => 'waves-effect waves-light btn green']) }}
                                            </p>
                                        @else
                                            <p> WAIT YOUR PAYMENT WILL VERIFIED BY US AND THEN YOU CAN DOWNLOAD THE RECPIET</p>
                                        @endif
                                     @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                @if($user->hasConfirmedAccomodation())
                    <form action="{{ env('PAYU_URL') }}" id="frm-payment" method="post">
                        <input type="hidden" name="key" value="{{ App\Payment::getPaymentKey() }}">
                        <input type="hidden" name="txnid" value="{{ $user->getTransactionId() }}">    
                        <input type="hidden" name="amount" value="{{ $user->getAccomodationAmount() }}">
                        <input type="hidden" name="productinfo" value="{{ App\Payment::getProductInfo() }}">
                        <input type="hidden" name="firstname" value="{{ $user->first_name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="phone" value="{{ $user->mobile }}">            
                        <input type="hidden" name="surl" value="{{ route('user_pages.payment.success', ['type' => 'accomodation']) }}">   
                        <input type="hidden" name="furl" value="{{ route('user_pages.payment.failure') }}">
                        <input type="hidden" name="hash" value="{{ Auth::user()->getHash(Auth::user()->getAccomodationAmount()) }}">
                    </form>
                    @endif
                    <div class="modal" id="modal-confirm">
                        <div class="modal-content">
                        <h4>Are you sure?</h4>
                        <p>
                            After confimration you want HOSPITALITY?
                        </p>
                        </div>
                        <div class="modal-footer">
                            <a class="btn-flat waves-effect waves-red modal-action modal-close">No not now!</a>
                            {{ link_to_route('user_pages.hospitality.request', 'Got it!', null, ['class' => 'btn-flat waves-effect waves-green modal-action modal-close']) }}        
                        </div>
                    </div>
                    
            @else
            <p class="red-text">ACCOMODATION REGISTERATION WILL BE OPENING SOON </p>
            @endif
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
<script>
    $('#btn-upload-ticket').on('click', function(){
        $('#file-ticket').trigger('click');
    });
    $('#file-ticket').on('change', function(){
        $('#form-upload-ticket').submit();
    });
</script>

@endif
@endsection

