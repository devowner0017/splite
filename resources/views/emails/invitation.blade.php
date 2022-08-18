@extends('emails.base')

@section('subject', 'CHIL Event Invitation');

@section('content')
    <h1>{{ $contact->first_name }}, you are invited!</h1>
    <h5>Click the button below to see the details of your invitation!</h5>
    <a href="{{ env('PUBLIC_URL') }}/invitation/{{ $invitation->hash }}">Open</a>
@endsection
