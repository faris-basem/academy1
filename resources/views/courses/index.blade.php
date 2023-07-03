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

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة كورس</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الكورسات</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="courses-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الكورس</th>
                                <th>اسم المرحلة</th>
                                <th>الأقسام</th>
                                <th>الصورة</th>
                                <th>الوصف</th>
                                <th>الحالة</th>
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

    {{-- add course --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة كورس</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_course_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الكورس </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">إسم المرحلة</label>
                                <select name="level_id" class="form-control" id="exampleFormControlSelect1">
                                    <?php $levels = \App\Models\Level::with('subject')->get(); ?>
                                    
                                    <option selected disabled>اختر مرحلة</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}">{{ $level->name}} ({{ $level->subject->name}})</option>
                                    @endforeach
                                    
                                </select>
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
                                <div class="col-md-6">
                                    <label style="font-size:20px">الحالة </label>                              
                                    <select name="type" class="form-control" id="type">  
                                        <option selected disabled>اختر حالة</option>
                                        <option value="0">مجاني</option>
                                        <option value="1">مدفوع</option>                                
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">الصورة </label>
                                    <div class="form-group">
                                        <input type="file" name="img" id="img" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_course2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_course" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit course --}}
    <div class="form-modal-ex">
        <div class="modal fade text-left" id="edit_course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> تعديل كورس</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit_course_form">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الكورس </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size:20px">إسم المرحلة</label>
                                <select name="level_id" class="form-control" id="select2">
                                    <?php $levels = \App\Models\Level::with('subject')->get(); ?>
                                    
                                    <option selected disabled>اختر مرحلة</option>
                                    @foreach($levels as $level)
                                         <option value="{{ $level->id }}">{{ $level->name}} ({{ $level->subject->name}})</option>
                                    @endforeach
                                </select>
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
                                <div class="col-md-6">
                                    <label style="font-size:20px">الصورة </label>
                                    <div class="form-group">
                                        <input type="file" name="img" id="img2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="image_preview" style="cursor: pointer;">
                                            <img id="image_preview" style="width: 50%" src="" alt="Image Preview" style="max-width: 100%; max-height: 200px;">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                            <button type="button" style="display: none" id="edit_course2"
                                class="btn btn-primary btn-block">جاري التعديل ...</button>
                            <button type="button" id="edit_course1" class="btn btn-primary btn-block" onclick="do_edit()">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- delete course --}}
    <div class="modal fade modal-danger text-left" id="delete_course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف الكورس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_course_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="delete_course2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                            <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_course_button" data-dismiss="modal">تأكيد</button>
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

{{-- add course --}}
<script>
    $(document).on('click', '#add_course', function(e) {
        $('#name_error').text('');


        $("#add_course2").css("display", "block");
        $("#add_course").css("display", "none");
        var formData = new FormData($('#add_course_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_course') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                $("#add_course2").css("display", "none");
                $("#add_course").css("display", "block");
                $('.close').click();
                // toastr.success('level added successfully.');
                $('#position-top-start').click(); // Trigger the button click
                $('#name').val('');
                $('#exampleFormControlSelect1').val('');
                $('#description').val('');
                $('#type').val('');
                $('#img').val('');
            },

            error: function(reject) {
                $("#add_course2").css("display", "none");
                $("#add_course").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>

{{-- show courses --}}
<script type="text/javascript">

    $(function () {
        var table = $('#courses-table').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($level_id))
               ajax: "{{ route('get_courses_data',$level_id) }}",
            @else
               ajax: "{{ route('get_courses_data') }}",
            @endif
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'level', name:'level'},
                {data: 'sections', name : 'sections'},
                {data: 'img', name : 'img'},
                {data: 'description', name : 'description'},
                {data: 'type', name : 'type'},
                {data: 'action',searchable:false},
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']], // page length options
        });
    });
    
    </script>

    {{-- edit level--}}
    <script>
        $('#edit_course').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var name     =  button.data('name')
            var level_id     =  button.data('level_id')
            var description     =  button.data('description')
            var type     =  button.data('type')
            var img     =  button.data('img2')
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #select2').val(level_id);
            modal.find('.modal-body #description2').val(description);
            modal.find('.modal-body #type2').val(type);
            modal.find('.modal-body #image_preview').attr('src',img);

            modal.find('.modal-body #image_preview').click(function() {
                modal.find('.modal-body #img2').click();
            });
        
        });
    </script>
    
    <script>
        function do_edit(){
            $("#edit_course1").css("display", "none");
            $("#edit_course2").css("display", "block");
            var formData = new FormData($('#edit_course_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('edit_course')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#edit_course2").css("display", "none");
                    $("#edit_course1").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_edit').click();
                    $('#name2').val('');
                }, error: function (reject) {
                    $("#edit_course2").css("display", "none");
                    $("#edit_course1").css("display", "block");
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
        $('#delete_course').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>
    <script>
        function do_delete(){
            $("#delete_course_button").css("display", "none");
            $("#delete_course2").css("display", "block");
            var formData = new FormData($('#delete_course_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('delete_course')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_course2").css("display", "none");
                    $("#delete_course_button").css("display", "block");
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
