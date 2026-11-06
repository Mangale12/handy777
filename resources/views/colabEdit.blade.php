@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Edit Noorgamers') }}</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Error!</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            <p>{{ $error }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">

                            <div class="col-lg-12 margin-tb">

                                <div class="pull-left">

                                    <h2>Edit</h2>

                                </div>

                                <div class="pull-right">

                                    <a class="btn btn-success" href="{{ route('home') }}"> Back</a>
                                    <a class="btn btn-primary" href="{{ route('day') }}"> Days</a>

                                </div>

                            </div>

                        </div>



                        @if ($message = Session::get('success'))

                            <div class="alert alert-success">

                                <p>{{ $message }}</p>

                            </div>

                        @endif


                        <form action="{{ route('colab.update') }}" method="POST">
                            {{ csrf_field() }}
                            </br>
                            <input style="display:none;" type=""hidden" value="{{$form->id}}" name="id">
                            <div class="row">
                                <div class="col">
                                    <span>Full name </span>
                                    <input type="text" class="form-control" name="extra_2"
                                        value="{{ $form->extra_2 }}" placeholder="Full Name">
                                </div>
                                <div class="col">
                                    <span>Phone</span>
                                    <input type="text" class="form-control" value="{{ $form->phone_number }}" name="phone_number"
                                        placeholder="Phone" maxlength="10" >
                                </div>
                            </div>
                            </br>
                               <div class="row">
                                <div class="col">
                                    <span>Note </span>
                                    <input type="text" class="form-control" value="{{ $form->note }}" name="note"
                                        placeholder="Note" >
                                </div>

                            </div>
                            </br></br>
                            <button type="submit" class="btn btn-primary mb-2">Confirm</button>
                        </form>


                    @endsection
