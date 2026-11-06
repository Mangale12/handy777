

<form action="{{ route('forms.destroy',$id) }}" method="POST" style="white-space: nowrap;">
    <a href="{{ route('forms.edit',$id) }}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit">
    <i class="fa fa-edit"></i>
    </a>
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger confirm-delete">
    <i class="fa fa-trash"></i>
    </button>
</form>
            
