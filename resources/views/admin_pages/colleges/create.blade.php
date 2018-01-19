@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.error')
        <div class="card rounded-box">
            <div class="card-content">
                <div class="card-title center-align">
                    Create College
                </div>
                {!! Form::model($college, ['url' => route('admin::colleges.store')]) !!}
                    @include('admin_pages.colleges.partials.form')
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
    
@endsection