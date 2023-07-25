

@can('تعديل الاختبارات')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_quiz" data-id="{{ $data->id }}"
    data-name="{{ $data->name }}" data-lesson_id="{{ $data->lesson_id }}"
    data-type="{{ $data->type }}" data-input_type="{{ $data->input_type }}" data-time="{{ $data->time }}"
    data-question_num="{{ $data->question_num }}"data-attempts="{{ $data->attempts }}"
    data-points="{{ $data->points }}"data-notes="{{ $data->notes }}"
    data-deduction_per_attempt="{{ $data->deduction_per_attempt }}"> <i class="fa fa-edit"></i> تعديل </a>
@endcan



@can('حذف الاختبارات')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_quiz" data-id="{{ $data->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan


