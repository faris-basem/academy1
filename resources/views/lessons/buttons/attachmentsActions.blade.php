

@can('تعديل المرفقات')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_attachment" data-id="{{ $data->id }}"
    data-file_name="{{ $data->file_name }}" data-lesson_id="{{ $data->lesson_id }}"> <i class="fa fa-edit"></i> تعديل </a>
@endcan



@can('حذف المرفقات')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_attachment" data-id="{{ $data->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan


