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
                   
                        {!! Form::open(['url' => route('password.request')]) !!}
                            @include('auth.partials.resetform')
                        {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
