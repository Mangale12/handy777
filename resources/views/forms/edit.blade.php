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


                        <form action="{{ route('update.form', $form->id) }}" method="POST">
                            {{ csrf_field() }}
                            </br>
                            <div class="row">
                                <div class="col">
                                    <span>Full name </span>
                                    <input type="text" class="form-control" name="full_name"
                                        value="{{ $form->full_name }}" placeholder="Full Name">
                                </div>
                                <div class="col">
                                    <span>Email</span>
                                    <input type="text" class="form-control" value="{{ $form->email }}" name="email"
                                        placeholder="Email">
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col">
                                    <span>Phone</span>
                                    <input type="text" class="form-control" value="{{ $form->number }}" name="number"
                                        placeholder="Phone" maxlength="10" >
                                </div>
                                <div class="col">
                                    <span>Interval comming</span>
                                    <input type="text" class="form-control" value="{{ $form->intervals }}"
                                        name="intervals" placeholder="Interval" >
                                </div>
                                <div class="col">
                                    <span>Counter</span>
                                    <input type="text" class="form-control" value="{{ $form->count }}" name="count"
                                        placeholder="count">
                                </div>
                            </div></br>
                              <div class="row">
                               
                                <div class="col">
                                    <span>Game Id</span>
                                    <input type="text" class="form-control" value="{{ $form->game_id }}"
                                        name="game_id" placeholder="Game Id">
                                </div>
                                <div class="col">
                                    <span>Facebook User</span>
                                    <input type="text" class="form-control" value="{{ $form->facebook_name }}" name="facebook_name" placeholder="facebook_name" >
                                </div>
                            </div>
                            </br>
                            <div class="row">
                                <div class="col">
                                    <span>State </span>
                                    <input type="text" class="form-control" value="{{ $form->mail }}" name="mail"
                                        placeholder="State" readonly>
                                </div>

                            </div>
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
