@extends('emails.base')

@section('subject', 'CHIL Verification Email');

@section('content')
    <h1>Dear User</h1>
    <p>Here's the verification code: {{ $code }}</p>
@endsection
