@extends('emails.base')

@section('subject', 'CHIL Invitation declined');

@section('content')
    <h1>{{ $invitation->event->planner->user->first_name }}, a contact {{ $invitation->contact->first_name }} declined your invitation</h1>
@endsection
