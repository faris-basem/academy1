

@can('تعديل الدورات')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_course" data-id="{{ $data->id }}"
    data-name="{{ $data->name }}" data-level_id="{{ $data->level_id }}" 
    data-description="{{ $data->description }}" data-type="{{ $data->type }}" data-img2="{{ $data->img }}"> <i class="fa fa-edit"></i> تعديل </a>
@endcan


@can('حذف الدورات')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_course" data-id="{{ $data->id }}"> 
    <i class="fa fa-trash"></i> حذف</a>
@endcan


