@extends('emails.base')

@section('subject', 'CHIL Invitation accepted');

@section('content')
    <h1>{{ $invitation->contact->first_name }}, you accepted the invitation</h1>
@endsection
