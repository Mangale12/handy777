@extends('newLayout.layouts.newLayout')

@section('title')
    Spinner Winner
@endsection
@section('content')
    @php
        use Carbon\Carbon;
    @endphp
    <style>
        .count-row {
            font-weight: 700;
        }

        .select2 {
            width: 100% !important;
        }


        .overlay {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            transition: opacity 500ms;
            visibility: hidden;
            opacity: 0;
            z-index: 9999;
        }

        .overlay:target {
            visibility: visible;
            opacity: 1;
        }


        .popup {
            margin: 70px auto;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            width: 50%;
            position: relative;
            transition: all 5s ease-in-out;



        }

        .popup h2 {
            margin-top: 0;
            color: #333;
            font-family: Tahoma, Arial, sans-serif;

        }

        .popup .close {
            position: absolute;
            top: 20px;
            right: 30px;
            transition: all 200ms;
            font-size: 30px;
            font-weight: bold;
            text-decoration: none;
            color: #333;

        }

        .popup .close:hover {
            color: #FF9800;
        }

        .popup .content {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }

        @media screen and (max-width: 700px) {
            .box {
                width: 70%;
            }

            .popup {
                width: 70%;
            }
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-12 card">
            <div class="card-body">
                <p class="current-winner"> </p>
            </div>

            <button class="btn  btn-primary mb-0" style="background-color:#FF9800;">
                <a class="choose-winner" href="#popup3" style="color:white;">Choose Winner</a></button>
            <div id="popup3" class="overlay" style="z-index: 9;">
                <div class="popup">
                    <h2>Choose Winner</h2>
                    <p class="warn-text"></p>
                    <a class="close" href="#">&times;</a>
                    <div class="content ">
                        <form action="{{ route('set-winner') }}" method="post">
                            @csrf
                            <input name="id" type="hidden" value="0" class="form-id">
                            <div class="row">
                                <div class="form-group">

                                    <select class="form-control " name="id" id="player-list">
                                    </select>
                                </div>
                                <button type="submit" class="btn  btn-primary mb-0"
                                    style="background-color:#FF9800;">Send</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 card">
            <div class="card-body">
                {{-- <div class="row justify-content-between">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg1">Restore</button>

            </div> --}}
            </div>
            <div class="table-responsive p-4" style="overflow-x:auto;">
                <!--id="datatable-crud"-->
                    <table class="table datatable" style="font-size:14px">
                        <thead>
                            <tr>
                                <th style="width: 26.328100000000006px!important;">No</th>
                                <th class="cus-width">Date</th>
                                <th class="cus-width">Full Name</th>
                                <th class="cus-width">Number</th>
                                <th class="cus-width">Email</th>
                                <th class="cus-width">Fb ID</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            <script>
                                var currentWinner = '';
                            </script>
                            @foreach ($winners as $num)
                                <tr class="tr-{{ $num->id }}">
                                    @if (date('Y') == date('Y', strtotime($num->created_at)) && date('m') == date('m', strtotime($num->created_at)))
                                        <script>
                                            var currentWinner = '{{ $num->full_name }}';
                                        </script>
                                    @else
                                    @endif
                                    <td class="count-row">{{ $count++ }}</td>
                                    <td>
                                        {{ date('Y M', strtotime($num->created_at)) }}
                                    </td>
                                    <td>
                                        {{ ucwords($num->full_name) }}
                                    </td>
                                    <td>
                                        {{ isset($num->form->number) ? $num->form->number : '' }}
                                    </td>
                                    <td>
                                        {{ isset($num->form->email) ? $num->form->email : '' }}
                                    </td>
                                    <td>
                                        {{ isset($num->form->facebook_name) ? $num->form->facebook_name : '' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>

        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        setTimeout(() => {
            $('#player-list').select2({            
                dropdownParent: $('#popup3')
            });
        }, 1000);
        if (currentWinner != '') {
            $('.current-winner').text('This months winner is ' + currentWinner);
            $('.warn-text').text('This months winner is ' + currentWinner + '. Do you wish to change it?');

        } else {
            console.log('no winner');
        }


        $('.choose-winner').on('click', function() {
            $.ajax({
                url: window.location.origin + '/get-players-list',
                method: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    $('#player-list').html(data);
                }
            })
        });
    </script>
@endsection
