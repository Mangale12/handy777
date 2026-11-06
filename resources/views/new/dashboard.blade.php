@extends('layouts.newLayout')

@section('title')
     Dashboard 
@endsection
@section('content')

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card ">
                                <div class="card-header ">
                                    <h4 class="card-title">{{$total}}</h4>
                                </div>
                                <div class="card-body ">
                                    <p class="card-category">Total Noor Gamers</p>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection

