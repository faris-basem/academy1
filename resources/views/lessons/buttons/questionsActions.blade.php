

@can('تعديل اسئلة الاختبارات')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_question" data-id="{{ $data->id }}"
    data-question="{{ $data->question }}" data-quiz_id="{{ $data->quiz_id }}"> <i class="fa fa-edit"></i> تعديل </a>
@endcan



@can('حذف اسئلة الاختبارات')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_question" data-id="{{ $data->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan


