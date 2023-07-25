

@can('تعديل المواد')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_subject" data-id="{{ $subjects->id }}"
    data-name="{{ $subjects->name }}"> <i class="fa fa-edit"></i> تعديل </a>
@endcan



@can('حذف المواد')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_subject" data-id="{{ $subjects->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan
