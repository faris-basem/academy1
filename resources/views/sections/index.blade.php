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

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة قسم</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الأقسام</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="sections-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم القسم</th>
                                <th>اسم الكورس</th>
                                <th>الدروس</th>
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

    {{-- add section --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة قسم</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_section_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم القسم </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">إسم الكورس</label>
                                <select name="course_id" class="form-control" id="exampleFormControlSelect1">
                                    <?php $courses = \App\Models\Course::get(); ?>
                                    
                                    <option selected disabled>اختر كورس</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name}}</option>
                                    @endforeach
                                    
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_section2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_section" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit section --}}
    <div class="form-modal-ex">
        <div class="modal fade text-left" id="edit_section" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> تعديل كورس</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit_section_form">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم القسم </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-size:20px">إسم الكورس</label>
                                <select name="course_id" class="form-control" id="select2">
                                    <?php $courses = \App\Models\Course::get(); ?>
                                    
                                    <option selected disabled>اختر كورس</option>
                                    @foreach($courses as $course)
                                         <option value="{{ $course->id }}">{{ $course->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="edit_section2"
                                class="btn btn-primary btn-block">جاري التعديل ...</button>
                            <button type="button" id="edit_section1" class="btn btn-primary btn-block" onclick="do_edit()">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- delete section --}}
    <div class="modal fade modal-danger text-left" id="delete_section" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف الكورس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_section_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="delete_section2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                            <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_section_button" data-dismiss="modal">تأكيد</button>
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

{{-- add section --}}
<script>
    $(document).on('click', '#add_section', function(e) {
        $('#name_error').text('');


        $("#add_section2").css("display", "block");
        $("#add_section").css("display", "none");
        var formData = new FormData($('#add_section_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_section') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                $("#add_section2").css("display", "none");
                $("#add_section").css("display", "block");
                $('.close').click();
                // toastr.success('level added successfully.');
                $('#position-top-start').click(); // Trigger the button click
                $('#name').val('');
                $('#exampleFormControlSelect1').val('');
            },

            error: function(reject) {
                $("#add_section2").css("display", "none");
                $("#add_section").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>

{{-- show sections --}}
<script type="text/javascript">

    $(function () {
        var table = $('#sections-table').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($course_id))
               ajax: "{{ route('get_sections_data',$course_id) }}",
            @else
               ajax: "{{ route('get_sections_data') }}",
            @endif
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'course', name:'course'},
                {data: 'lessons', name : 'lessons'},
                {data: 'action',searchable:false},
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']], // page length options
        });
    });
    
    </script>

    {{-- edit section--}}
    <script>
        $('#edit_section').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var name     =  button.data('name')
            var course_id     =  button.data('course_id')
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #select2').val(course_id);
            
        });
    </script>
    
    <script>
        function do_edit(){
            $("#edit_section1").css("display", "none");
            $("#edit_section2").css("display", "block");
            var formData = new FormData($('#edit_section_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('edit_section')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#edit_section2").css("display", "none");
                    $("#edit_section1").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_edit').click();
                    $('#name2').val('');
                }, error: function (reject) {
                    $("#edit_section2").css("display", "none");
                    $("#edit_section1").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
                }
            });
    }
    </script>

    {{-- delete section--}}
    <script>
        $('#delete_section').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>
    <script>
        function do_delete(){
            $("#delete_section_button").css("display", "none");
            $("#delete_section2").css("display", "block");
            var formData = new FormData($('#delete_section_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('delete_section')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_section2").css("display", "none");
                    $("#delete_section_button").css("display", "block");
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
