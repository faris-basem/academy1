

@can('حذف المواد')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_student" data-id="{{ $student->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan
