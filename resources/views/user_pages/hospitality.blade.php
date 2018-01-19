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
                                    YOU MUST HAVE REGISTERED BOTH WORKSHOP AND EVENTS
                                </li>
                                <br>
                                <li>
                                    IT IS BASED ON FIRST COME FIRST SERVER
                                </li>
                                <br>
                                <li>
                                    You need to pay 100 rupees per head per day
                                </li>
                                <br>
                                <li>
                                    ACCOMDATION IS AVAILABLE FOR ONE DAY ONLY
                                </li>
                            </ul>
                        </p>
                        @if(!$user->hasConfirmedAccomodation() && !$user->hasRegisteredBoth() )
                        <a class="btn waves-effect waves-light green modal-trigger" href="#modal-confirm">Confirm and generate ticket</a>
                        @else
                        <a class="btn waves-effect waves-light green modal-trigger disabled">Confirm and generate ticket</a>
                        @endif       
                    </div>
                </li>
                <li class="step {{ $user->hasConfirmedAccomodation()?'active':'' }}">
                    <div class="step-title waves-effect waves-dark">CONFIRM UR HOSPITALITY</div>
                        <div class="step-content">
                                <div class="container">
                                <p>
                                    <input name="mode_of_payment" type="radio" id="online" />
                                    <label for="online">ONLINE PAYMENT</label>
                                    <input name="mode_of_payment" type="radio" id="DD" />
                                    <label for="DD">DEMAND DRAFT</label>
                                </p>
                                </div>
                                <div id="payu">
                                    @if($user->hasConfirmedAccomodation())
                                    <button type="button" onclick="$('#frm-payment').submit()" class="btn waves-effect waves-light green"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                    @else
                                        <button type="submit"  class="btn waves-effect waves-light green disabled"><i class="fa fa-credit-card"></i> Pay by PayUmoney</button>
                                    @endif
                                </div>
                                <div id="draft">
                                    @if($user->hasConfirmedAccomodation())
                                    <p>
                                        @include('partials.error')                        
                                            {!! Form::open(['url' => route('user_pages.ticket.upload'), 'files' => true, 'id' => 'form-upload-ticket', 'style' => 'display:inline']) !!}
                                            {!! Form::file('demand_draft', ['class' => 'hide', 'id' => 'file-ticket']) !!}
                                            {!! Form::close() !!}
                                            <button type="button" class="btn waves-effect waves-light green {{ $user->hasConfirmed()?'':'disabled' }}" id="btn-upload-ticket">Upload Ticket</button>
                                    </p>
                                    @endif
                                </div>
                        
                            
                        </div>
                    </div>
                </li>
                
            </ul>
        </div>
        @if($user->hasConfirmedTeams())
            <form action="{{ env('PAYU_URL') }}" id="frm-payment" method="post">
                <input type="hidden" name="key" value="{{ App\Payment::getPaymentKey() }}">
                <input type="hidden" name="txnid" value="{{ $user->getTransactionId() }}">    
                <input type="hidden" name="amount" value="{{ $user->getAccomodationAmount() }}">
                <input type="hidden" name="productinfo" value="{{ App\Payment::getProductInfo() }}">
                <input type="hidden" name="firstname" value="{{ $user->first_name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="hidden" name="phone" value="{{ $user->mobile }}">            
                <input type="hidden" name="surl" value="{{ route('user_pages.payment.success') }}">   
                <input type="hidden" name="furl" value="{{ route('user_pages.payment.failure') }}">
                <input type="hidden" name="hash" value="{{ Auth::user()->getHash(Auth::user()->getAccomodationAmount()) }}">
            </form>
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

        @endif
    @else
    <p>Overed</p>
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


@endif
@endsection

