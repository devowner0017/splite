@extends('emails.base')

@section('subject', 'CHIL Invitation accepted');

@section('content')
    <h1>{{ $invitation->event->planner->user->first_name }}, a contact {{ $invitation->contact->first_name }} accepted your invitation</h1>
@endsection
