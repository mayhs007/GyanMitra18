@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col offset-m2 m8 s12">
        @include('partials.error')
        <div class="card">
            <div class="card-content">
                <div class="card-title center-align">
                    Edit Prizes For {{ $event->title }}
                </div>
                {!! Form::open(['url' => route('admin::events.prizes.update', ['event' => $event->id]), 'method' => 'PUT']) !!}
                    @include('admin_pages.prizes.partials.form')
                {!! Form::close() !!}  
            </div>
        </div>
    </div>
</div>

@endsection