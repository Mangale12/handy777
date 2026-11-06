<form class="formEditForm" id="formEditForm" method="POST" action="{{route('gameUpdate', $form->id)}}">
    @csrf
    <div class="row">
        <div class="col-6">
            <label for="name" class="form-label">Name</label>
            <input required name="name" type="text" class="form-control name" id="name" placeholder="Name" value="{{ $form->name }}">
        </div>
        <div class="col-6">
            <label for="title" class="form-label">Title</label>
            <input required name="title" type="text" class="form-control title" id="title" placeholder="Title" value="{{ $form->title }}">
        </div>
        <div class="col-6 mt-2">
            <label for="balance" class="form-label">Balance</label>
            <input required name="balance" type="number" class="form-control balance" id="balance" placeholder="Balance" value="{{ $form->balance }}">
        </div>
        <div class="col-6 mt-2">
            <label for="game-url" class="form-label">Game URL</label>
            <input required name="game_url" type="text" class="form-control game-url" id="game-url" placeholder="Game URL" value="{{ $form->game_url }}">
        </div>
        <div class="col-6 mt-2">
            <label for="status" class="form-label">Status</label>
            <select required name="status" id="" class="form-control status">
                <option {{ ($form->status == 'active')?'selected':'' }} value="active">Active</option>
                <option {{ ($form->status == 'inactive')?'selected':'' }} value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-12 mt-2">
            <button class="" type="submit">Submit</button>
        </div>
    </div>
</form>
<script>
      $('.formSubmitBtn').on('click',function(e) {
          e.preventDefault();
            var datastring = $(".formEditForm").serialize();
            var cid = $(this).data('id');
           
          var name =  document.getElementsByClassName('name').value;
          alert(name);
            
            var title = $('.title').val();
            var balance = $('.balance').val()
            var status = $('.name').val();
            alert(name);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
           
            var dataSend = {
                'name' : name,
                'title' : title,
                'balance' : balance,
                'status' : status,
            };
                        $.ajax({
                        type: 'post',
                        url: "/games/update/"+cid,
                        data: {
                            'name' : name,
                            'title' : title,
                            'balance' : balance,
                            'status' : status,
                        },
                       
                        success: function (data) {
                            console.log(data);
                            $('.editFormModal').modal('hide');
                            $('.td-name-'+cid).text((data.name));
                            $('.td-title-'+cid).text(data.title);
                            $('.td-balance-'+cid).text(data.balance);
                            $('.td-status-'+cid).text((data.status));

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