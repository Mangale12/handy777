<form class="formEditForm">
    {{-- action="{{ route('gamerUpdate', $form->id) }}" method="POST" --}}
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
            <textarea class="form-control"  cols="30" rows="5" name="note">{{ $form->note }}</textarea>
            {{-- <input type="text" class="form-control" value="{{ $form->note }}" name="note"
                placeholder="Note" > --}}
        </div>

    </div>
    </br></br>
    {{-- type="submit" --}}
    <a href="javascript:void(0);" class="btn btn-primary mb-2 formSubmitBtn" data-id="{{$form->id}}">Confirm</a>
    {{-- <button  class="btn btn-primary mb-2 formSubmitBtn">Confirm</button> --}}
</form>
<script>
      $('.formSubmitBtn').on('click',function(e) {
            var datastring = $(".formEditForm").serialize();
            var cid = $(this).data('id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var dataSend = {
                'full_name' : $('input[name="full_name"]').val(),
                'email' : $('input[name="email"]').val(),
                'number' : $('input[name="number"]').val(),
                'intervals' : $('input[name="intervals"]').val(),
                'count' : $('input[name="count"]').val(),
                'game_id' : $('input[name="game_id"]').val(),
                'facebook_name' : $('input[name="facebook_name"]').val(),
                'mail' : $('input[name="mail"]').val(),
                'note' : $('textarea[name="note"]').val(),
            };
                        $.ajax({
                        type: 'post',
                        url: "/gamers/update/"+cid,
                        data: {
                            "data": dataSend,
                        },
                        dataType: 'json',
                        success: function (data) {
                            console.log(data);
                            $('.editFormModal').modal('hide');
                            $('.td-full_name-'+cid).text(data.full_name);
                            $('.td-game_id-'+cid).text(data.game_id);
                            $('.td-facebook_name-'+cid).text(data.facebook_name);
                            $('.td-mail-'+cid).text(data.mail);
                            $('.td-r_id-'+cid).text(data.r_id);
                            $('.td-count-'+cid).text(data.count);
                            $('.td-note-'+cid).text(data.note);

                            var monthShortNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                            var date_format = new Date(data.intervals);
                            var a = date_format.getDate() + ' ' + monthShortNames[date_format.getMonth()] + ', ' + date_format.getFullYear();
                            $('.td-intervals-'+cid).text(a);
                            // console.log(data);
                            // $('.editFormModalBody').append(data);
                            // $( ".count-row" ).each(function( index ) {
                                // $(this).text((index+1));
                                // console.log( index + ": " + $( this ).text() );
                            // })
                            toastr.success('Success',"Form Updated");
                            
                        },
                        error: function (data) {
                            console.log(data);
                            toastr.error('Error',data.responseText);
                        }
                    });
            console.log(datastring);
        });
</script>