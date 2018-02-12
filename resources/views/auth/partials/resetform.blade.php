<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">account_circle</i>
        {!! Form::label('email') !!}
        {!! Form::text('email') !!}
    </div>
</div>
<div class="row">
    <div class="col s6 input-field">
        {!! Form::hidden('token',$token) !!}
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">vpn_key</i>                        
        {!! Form::label('password') !!}
        {!! Form::password('password') !!}
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">dialpad</i>
        {!! Form::label('password_confirmation') !!}
        {!! Form::password('password_confirmation') !!}
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        {!! Form::submit('Reset Password', ['class' => 'btn waves-effect waves-light green']) !!}
    </div>
</div>
