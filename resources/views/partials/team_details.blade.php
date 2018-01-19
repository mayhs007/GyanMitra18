<ul class="collapsible" data-collapsible="accordion">
    <li>
        <div class="collapsible-header">
            <strong>{{ $team->name }} Details</strong>
        </div>
        <div class="collapsible-body">
            <ul class="collection">
                @if($team->user->hasPaid())
                    <span class="new badge green" data-badge-caption="Paid"></span>
                @else
                    <span class="new badge red" data-badge-caption="Not Paid"></span>
                @endif
                <span class="new badge blue" data-badge-caption="Leader"></span>           
                <li class="collection-item">
                    {{ $team->user->first_name }} {{ $team->user->last_name }} ({{ $team->user->GMId() }})
                </li>
                @foreach($team->teamMembers as $teamMember)
                    @if($teamMember->user->hasConfirmed())
                        @if($teamMember->user->hasPaid())
                            <span class="new badge green" data-badge-caption="Paid"></span>
                        @else
                            <span class="new badge red" data-badge-caption="Not Paid"></span>
                        @endif
                        <span class="new badge lighten-2 green" data-badge-caption="Confirmed"></span>
                    @else
                        <span class="new badge lighten-2 red" data-badge-caption="Not Confirmed"></span>
                    @endif
                    <li class="collection-item">
                        {{ $teamMember->user->first_name }} {{ $teamMember->user->last_name }} ({{ $teamMember->user->GMId() }})
                    </li>
                @endforeach
            </ul>
        </div>
    </li>
</ul>