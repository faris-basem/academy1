@extends('layouts.master')

@section('css')
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
@endsection

@section('title')
@endsection


@section('content')

    <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()"id="position-top-start_delete"></button>
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()"id="position-top-start_edit"></button>

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة درس</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الدروس</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="lessons-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الدرس</th>
                                <th>اسم القسم</th>
                                <th>رابط الفيديو</th>
                                <th>الوصف</th>
                                <th>الحالة</th>
                                <th>الاختبارات</th>
                                <th>المرفقات</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

    {{-- add lesson --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة درس</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_lesson_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الدرس </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">إسم القسم</label>
                                <select name="section_id" class="form-control" id="exampleFormControlSelect1">
                                    <?php $sections = \App\Models\Section::with('course')->get(); ?>
                                    
                                    <option selected disabled>اختر قسم</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name}} ({{ $section->course->name}})</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">رابط الفيديو </label>
                                    <div class="form-group">
                                        <input type="name" name="url_video" id="url_video" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">الوصف </label>
                                    <div class="form-group">
                                        <input type="name" name="description" id="description" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">الحالة </label>                              
                                    <select name="type" class="form-control" id="type">  
                                        <option selected disabled>اختر حالة</option>
                                        <option value="0">مجاني</option>
                                        <option value="1">مدفوع</option>                                
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_lesson2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_lesson" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit lesson --}}
    <div class="form-modal-ex">
        <div class="modal fade text-left" id="edit_lesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> تعديل درس</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit_lesson_form">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الدرس </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size:20px">إسم القسم</label>
                                <select name="section_id" class="form-control" id="select2">
                                    <?php $sections = \App\Models\Section::with('course')->get(); ?>
                                    
                                    <option selected disabled>اختر قسم</option>
                                    @foreach($sections as $section)
                                         <option value="{{ $section->id }}">{{ $section->name}} ({{ $section->course->name}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">رابط الفيديو </label>
                                    <div class="form-group">
                                        <input type="name" name="url_video" id="url_video2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">الوصف </label>
                                    <div class="form-group">
                                        <input type="name" name="description" id="description2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">الحالة </label>                              
                                    <select name="type" class="form-control" id="type2">  
                                        <option selected disabled>اختر حالة</option>
                                        <option value="0">مجاني</option>
                                        <option value="1">مدفوع</option>                                
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="edit_lesson2"
                                class="btn btn-primary btn-block">جاري التعديل ...</button>
                            <button type="button" id="edit_lesson1" class="btn btn-primary btn-block" onclick="do_edit()">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- delete lesson --}}
    <div class="modal fade modal-danger text-left" id="delete_lesson" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف الدرس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_lesson_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="delete_lesson2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                            <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_lesson_button" data-dismiss="modal">تأكيد</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')


<script>
    function msg_add() {

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت الإضافة بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

    }
    function msg_edit() {

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تم التعديل بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

    }
    function msg_delete() {

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت الحذف بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
                confirmButton: 'btn btn-danger'
            },
            buttonsStyling: false

        });

    }
</script>

{{-- add lesson --}}
<script>
    $(document).on('click', '#add_lesson', function(e) {
        $('#name_error').text('');


        $("#add_lesson2").css("display", "block");
        $("#add_lesson").css("display", "none");
        var formData = new FormData($('#add_lesson_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_lesson') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                $("#add_lesson2").css("display", "none");
                $("#add_lesson").css("display", "block");
                $('.close').click();
                // toastr.success('level added successfully.');
                $('#position-top-start').click(); // Trigger the button click
                $('#name').val('');
                $('#exampleFormControlSelect1').val('');
                $('#url_video').val('');
                $('#description').val('');
                $('#type').val('');
            },

            error: function(reject) {
                $("#add_lesson2").css("display", "none");
                $("#add_lesson").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>

{{-- show lessons --}}
<script type="text/javascript">

    $(function () {
        var table = $('#lessons-table').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($section_id))
               ajax: "{{ route('get_lessons_data',$section_id) }}",
            @else
               ajax: "{{ route('get_lessons_data') }}",
            @endif
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'section', name:'section'},
                {data: 'url_video', name : 'url_video'},
                {data: 'description', name : 'description'},
                {data: 'type', name : 'type'},
                {data: 'exams', name : 'exams'},
                {data: 'attachments', name : 'attachments'},
                {data: 'action',searchable:false},
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']], // page length options
        });
    });
    
    </script>

    {{-- edit lesson--}}
    <script>
        $('#edit_lesson').on('show.bs.modal', function(event) {
            var button     = $(event.relatedTarget)
            var id         = button.data('id')
            var name       = button.data('name')
            var section_id   = button.data('section_id')
            var url_video  = button.data('url_video')
            var description= button.data('description')
            var type       = button.data('type')
            var modal = $(this);
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #select2').val(section_id);
            modal.find('.modal-body #url_video2').val(url_video);
            modal.find('.modal-body #description2').val(description);
            modal.find('.modal-body #type2').val(type);
        
        });
    </script>
    
    <script>
        function do_edit(){
            $("#edit_lesson1").css("display", "none");
            $("#edit_lesson2").css("display", "block");
            var formData = new FormData($('#edit_lesson_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('edit_lesson')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#edit_lesson2").css("display", "none");
                    $("#edit_lesson1").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_edit').click();
                    $('#name2').val('');
                }, error: function (reject) {
                    $("#edit_lesson2").css("display", "none");
                    $("#edit_lesson1").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
                }
            });
    }
    </script>

    {{-- delete level--}}
    <script>
        $('#delete_lesson').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>
    <script>
        function do_delete(){
            $("#delete_lesson_button").css("display", "none");
            $("#delete_lesson2").css("display", "block");
            var formData = new FormData($('#delete_lesson_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('delete_lesson')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_lesson2").css("display", "none");
                    $("#delete_lesson_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();

                }, error: function (reject) {
                }
            });
    }
    </script>
    
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="//cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script src="{{asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('/app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

@endsection
