@extends('newLayout.layouts.newLayout')

@section('title')
    Plinko
@endsection

@section('content')
<style>
    /* The switch - Hide the default checkbox */
    .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
    }

    /* Hide the default checkbox */
    .switch input {
    opacity: 0;
    width: 0;
    height: 0;
    }

    /* The slider */
    .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
    }

    /* The slider when checked */
    .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    border-radius: 50%;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: 0.4s;
    }

    /* Change background color when checked */
    input:checked + .slider {
    background-color: #2196F3;
    }

    /* Move the slider to the right when checked */
    input:checked + .slider:before {
    transform: translateX(26px);
    }
</style>
    <div class="row justify-content-center">
        <div class="col-md-12 card">
            <div class="table-responsive p-4" style="overflow-x:auto;">
                <table class="table datatable" style="font-size:14px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Full Name</th>
                            <th>Number</th>
                            <th>Email</th>
                            <th>Facebook Name</th>
                            <th>Plinko Balance</th>
                            <th>Activate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $count=1;
                        ?>
                        @foreach($forms as $form)
                            <tr id="form_{{ $form->id }}">
                                <td>{{$count}}</td>
                                <td>{{ $form->full_name }}</td>
                                <td>{{ $form->number }}</td>
                                <td>{{ $form->email }}</td>
                                <td>{{ $form->facebook_name }}</td>
                                <td>{{ $form->plinko_balance }}</td>
                                <td>
                                    <label class="switch">
                                        <input type="checkbox" class="toggle-plinko" data-id="{{ $form->id }}" {{ $form->plinko_activate ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            <?php 
                                $count++;
                            ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.toggle-plinko').change(function() {
                var id = $(this).data('id');
                var isActivated = $(this).prop('checked') ? 1 : 0;

                // Disable the toggle until the process completes
                $(this).prop('disabled', true);

                $.ajax({
                    url: '/plinko/toggle/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        plinko_activate: isActivated
                    },
                    beforeSend: function() {
                        // Disable the toggle button and show a toastr message indicating processing
                        if(isActivated == 1){
                            toastr.info('Processing request... Email is being sent.');
                        }
                    },
                    success: function(response) {
                        // Show the activation message
                        toastr.success(response.activation_message);
                        
                        // Show the email status message
                        if (response.email_message) {
                            if (response.email_message === 'Email sent successfully') {
                                toastr.success(response.email_message);
                            } else {
                                toastr.error(response.email_message);
                            }
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong.');
                    },
                    complete: function() {
                        // Re-enable the toggle after the process completes (even if there's an error)
                        $('.toggle-plinko').prop('disabled', false);
                    }
                });

            });
        });

    </script>
@endsection
