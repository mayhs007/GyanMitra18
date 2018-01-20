@extends('layouts.admin')

@section('content')
    @include('admin_pages.partials.search_bar')
    <div class="row">
        <div class="col s12">
            @if($requests->count() == 0)
                <h5><i class="fa fa-check-circle"></i> Nothing to show!</h5>
            @endif
            <ul class="collapsible popout" data-collapsible="accordion">
                @foreach($requests as $request)
                    <li>
                        <div class="collapsible-header">
                            <strong>{{ $request->user->first_name }}</strong> From <strong>{{ $request->user->college->name }}</strong>
                            <a href="/uploads/Accomodation/demand_draft/{{ $request->user->Accomodation->acc_file_name }}" class= "right" target="_blank">View Ticket <i class="fa fa-eye"></i></a></td>
                        </div>
                        <div class="collapsible-body">
                            @include('admin_pages.partials.student_detail', ['user' => $request->user])
                            <p>
                                {!! Form::open(['url' => route('admin::accomodations')]) !!}   
                                    <div class="input-field">
                                        {!! Form::label('message') !!}
                                        {!! Form::text('message') !!}
                                        {!! Form::hidden('user_id', $request->user->id) !!}                            
                                    </div>
                                    <?php 
                                        $accepted = $request->user->accomodation->acc_status == 'ack'?'disabled':'';
                                        $rejected = $request->user->accomodation->acc_status == 'nack'?'disabled':'';
                                    ?>
                                    {!! Form::submit('Accept', ['class' => "btn green $accepted", 'name' => 'submit']) !!}
                                    {!! Form::submit('Reject', ['class' => "btn red $rejected", 'name' => 'submit']) !!}
                                {!! Form::close() !!}        
                            </p>    
                        </div>
                    </li>
                @endforeach   
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            {{ $requests->render() }}        
        </div>
    </div>
@endsection