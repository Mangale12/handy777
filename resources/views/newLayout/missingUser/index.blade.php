@extends('newLayout.layouts.newLayout')

@section('title')
Missing Users
@endsection
@section('content')
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- DataTables CSS and JS CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Select2 CSS and JS CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-lZ3+wnvN7rpApWQOzi5cGblC2lEX7i90xwM+eUch3NlDjG+6Vvj0o+uuBLq8Wm2XVefB7PvYJmJEUqUWv4YPLA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-DQDG7sw25iZUQ2/cUE3L3VWhVbLdD/9tFjGbUDE/BPLC+60yVcDZQzr4Gj7we7QYlRNZaM8XgJyhRZ93lR4eHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<div class="col-12">
	<div class="card">
		<div class="card-header">
			<div class="card-actions">
				<button class="btn  btn-primary" style="background-color:#FF9800;" data-toggle="modal" data-target="#addUserModal">
                   ADD USER
                 </button>
			</div>
		</div>
		<table class="table table-bordered data-table">
			<thead>
				<tr>
					<th>Game Id</th>
					<th>Account Name</th>
					<th>Tips</th>
					<th>Balance</th>
					<th>Refer</th>
					<th>Redeem</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <form action="{{route('addUser')}}" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body add-user-modal">
                            <label for="cars">User: Full Name [ Facebook Name ]</label>
                           
                                @csrf
                                
                                <select name="id" id="id" class="addUserSelect2" required>
                                    @if (isset($forms) && !empty($forms))
                                    @foreach($forms as $a => $num)
                                    <option value="{{$num['id']}}">{{$num['full_name']}}  [{{(!empty($num['facebook_name'])?$num['facebook_name']:'empty')}}]</option>
                                    @endforeach
                                    @else
                                    <option disabled>No Users</option>
                                    @endif
                                </select>
                                <br>
                                <label for="cars">Game Id:</label>
                                <input class="form-control" type="text" name="game_id" id="game_id" required>
                                {{-- <input class="form-control" type="text" value=""> --}}
                                <br>
                               
                          
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add to user <span class="user-name"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method='post' action="" class="save-form">
				<div class="modal-body">
					
					@csrf
					<div class="form-group">
						<label class="form-label">User:Full Name [Facebook Name]</label>
						<select   name="form_id" class="form-control facebook-user select-option-wrapper" required>
							<option value="">Select</option>
							@foreach($forms as $form)
							<option value="{{$form['id']}}">{{$form['full_name']}} {{$form['facebook_name'] ? '('.$form['facebook_name'].')' : ''}}</option>
							@endforeach
						</select>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary saveToUser">Add</button>
				</div>
			</form>
		</div>

	</div>
</div>
@endsection


@section('script')
<script type="text/javascript">
	$(function () {
		var table = $('.data-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('missingUser') }}",
			columns: [
				{data: 'game_id', name: 'game_id',orderable:false},
				{data: 'account.name', name: 'account.name',orderable:false,defaultContent:''},
				{data: 'tips', name: 'tips',searchable:false},
				{data: 'balance', name: 'balance',searchable:false},
				{data: 'refer', name: 'refer',searchable:false},
				{data: 'redeem', name: 'redeem',searchable:false},
				{data: 'action', name: 'action', orderable: false, searchable: false,
				render: function(datal, type,
					full, meta
					){
					return `<a  class="btn btn-primary addToUser" data-toggle="modal" data-target="#exampleModal" data-id=${full.id} data-name=${full.game_id}>Add User</a>`;

				}},
			]
		});
		$('.addUserSelect2').select2({
			dropdownParent: $('#addUserModal')
		})
		$('.facebook-user').select2({
			dropdownParent:$('#exampleModal')
		})

	});
	$(document).on('click','.addToUser',function(){
		const game_id = $(this).data('name')
		const id = $(this).data('id')
		$('.user-name').html(`(${game_id})`)
		const action = '{{url("add-to-user")}}/' +id
		$('.save-form').attr('action',action)
	})
	                                                                  

</script>
@endsection