@extends('newLayout.layouts.newLayout')

@section('title', 'Add Chat Email')

@section('content')
    @include('admin.chat-emails._form', [
        'formAction' => route('admin.chat-emails.store'),
        'formMethod' => 'POST',
        'heading' => 'Add Chat Email',
        'submitLabel' => 'Save',
    ])
@endsection
