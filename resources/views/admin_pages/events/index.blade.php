

@extends('layouts.admin')

@section('content')
<br>
<div class="container">
<div class="row">
    <div class="col s6">
        {{ link_to_route('admin::events.create', 'New Event', null, ['class' => 'btn waves-effect waves-light green']) }}
    </div>
</div>
</div>
<div class="row">
    @foreach($events as $event)
    <div class="col m6 s12">
            @include('partials.events', ['event' => $event])
        </div>
   
    @endforeach
<div class="row"> 
    <div class="col s12">
        {{ $events->render() }}
    </div>
</div>
<script>
    $(function(){
        $(".btn-delete-event").on('click', function(evt){
            var confimation = confirm('Are you sure to delete this event?');
            if(!confimation){
                return false;
            }
        });
    });
</script>
@endsection