
@can('تعديل اجابات الاسئلة')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_answer" data-id="{{ $data->id }}"
    data-answer="{{ $data->answer }}" data-status="{{ $data->status }}" data-question_id="{{ $data->question_id }}"> <i class="fa fa-edit"></i> تعديل </a>
@endcan



@can('حذف اجابات الاسئلة')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_answer" data-id="{{ $data->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan


