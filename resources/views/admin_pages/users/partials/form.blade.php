<div class="row">
    <div class="col s6 input-field">
        <i class="material-icons prefix">account_circle</i>
        {!! Form::label('first_name') !!}
        {!! Form::text('first_name') !!}
    </div>

    <div class="col s6 input-field">
        <i class="material-icons prefix">account_circle</i>
        {!! Form::label('last_name') !!}
        {!! Form::text('last_name') !!}
    </div>
</div>

<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">email</i>                    
        {!! Form::label('email') !!}
        {!! Form::text('email') !!}
    </div>
</div>
<div class="row">
    <div class="col s12 input-field">
        <i class="material-icons prefix">vpn_key</i>                        
        {!! Form::label('password') !!}
        {!! Form::password('password') !!}
    </div>
</div>

<p>
    @foreach($roles as $role)
    
        {!! Form::checkbox('roles[]', $role->id, $user->hasRole($role->role_name),  ['id' => 'role' . $role->id]) !!}
        {!! Form::label('role'.$role->id, $role->role_name) !!}
      
    @endforeach
</p>
<div class="row">
<div class="col s12 input-field">
    {!! Form::submit('Submit', ['class' => 'btn waves-effect waves-light green']) !!}
</div>
</div>