@extends('emails.base')

@section('subject', 'CHIL Payment completed');

@section('content')
    <h1>{{ $invitation->contact->first_name }}, you completed the payment</h1>
@endsection
