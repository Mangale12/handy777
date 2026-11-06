@extends('layouts.newLayout')

@section('title')
    Gamer Edit
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header sidebar-wrapper" style="background: {{isset($color)?$color->color:'purple'}}">
                        <div class="row">

                            <div class="col-lg-6 col-md-12 pull-left">

                                    
                            <h2 class="mt-0">Edit</h2>   

                        </div>
                        <div class="col-lg-6 col-md-12 pull-right">

                            {{-- <a style="float: right" class="btn btn-primary" href="{{ route('day') }}"> Days</a> --}}

                            <a style="float: right;margin-right: 10px;" class="btn btn-success " href="{{ route('gamers') }}"> Back</a>
                        </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- @if ($errors->any())
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
                        @endif --}}

                        {{-- <div class="row">

                            <div class="col-lg-12 margin-tb">

                                

                               

                            </div>

                        </div> --}}



                        {{-- @if ($message = Session::get('success'))

                            <div class="alert alert-success">

                                <p>{{ $message }}</p>

                            </div>

                        @endif --}}


                        <form action="{{ route('gamerUpdate', $form->id) }}" method="POST">
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
                                    <?php 
                                        $number = $form->number;
                                        // Allow only Digits, remove all other characters.
                                        $number = preg_replace("/[^\d]/","",$number);
                                        
                                        // get number length.
                                        $length = strlen($number);

                                        // if number = 10
                                        if($length == 10) {
                                        $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $number);
                                        }
                                    ?> 
                                    <input id="phone-number" type="text" class="form-control" value="{{ $number }}" name="number"
                                        placeholder="Phone" maxlength="10" >
                                </div>
                                <div class="col">
                                    <span>Interval coming</span>
                                    <input type="date" class="form-control" value="{{date('Y-m-d', strtotime($form->intervals))}}"
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
                               <div class="row mt-3">
                                <div class="col">
                                    <span>Note </span>
                                    <textarea class="form-control" id="summernote" cols="30" rows="50" name="note">{{ $form->note }}</textarea>
                                    {{-- <input type="text" class="form-control" value="{{ $form->note }}" name="note"
                                        placeholder="Note" > --}}
                                </div>

                            </div>
                            </br></br>
                            <button type="submit" class="btn btn-primary mb-2">Confirm</button>
                        </form>


                    @endsection
