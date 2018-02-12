@extends('layouts.auth')

@section('content')
<div class="row">
        <div class="col offset-m2 m8 s12">
        @include('partials.error')
            <div class="card z-depth-2 rounded-box">
                <div class="card-content">
                    <span class="card-title center-align">
                        <i class="material-icons">dialpad</i> Reset Password
                    </span>
                    {!! Form::open(['url' => route('password.email')]) !!}
                    <div class="row">
                        <div class="col s12 input-field">
                            <i class="material-icons prefix">account_circle</i>
                                {!! Form::label('ENTER YOUR EMAIL') !!}
                                {!! Form::text('email') !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 input-field center">
                            {!! Form::submit('Send Password Reset Link', ['class' => 'btn waves-effect waves-light green']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
@endsection

