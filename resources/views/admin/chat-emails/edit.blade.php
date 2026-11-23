@extends('newLayout.layouts.newLayout')

@section('title', 'Edit Chat Email')

@section('content')
    @include('admin.chat-emails._form', [
        'formAction' => route('admin.chat-emails.update', $chatEmail),
        'formMethod' => 'PUT',
        'heading' => 'Edit Chat Email',
        'submitLabel' => 'Update',
    ])
@endsection
