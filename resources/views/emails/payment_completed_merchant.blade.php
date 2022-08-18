@extends('emails.base')

@section('subject', 'CHIL Payment completed');

@section('content')
    <h1>{{ $invitation->event->service->venue->merchant->user->first_name }}, a contact {{ $invitation->contact->first_name }} completed his payment</h1>
@endsection
