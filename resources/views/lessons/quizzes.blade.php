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

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة اختبار</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الاختبارات</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="quizzes-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم الاختبار</th>
                                <th>اسم الدرس</th>
                                <th>نوع المدخلات</th>
                                <th>نوع الاختبار</th>
                                <th>مدة الاختبار</th>
                                <th>عدد الأسئلة</th>
                                <th>عدد المحاولات</th>
                                <th>النقاط</th>
                                <th>الخصم لكل محاولة</th>
                                <th>الملاحظات</th>
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

    {{-- add quiz --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة اختبار</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_quiz_form">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الاختبار </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label for="exampleFormControlSelect1" style="font-size:20px">إسم الدرس</label>
                                    <select name="lesson_id" class="form-control" id="exampleFormControlSelect1">
                                        <?php $lessons = \App\Models\Lesson::with('section')->get(); ?>
                                        
                                        <option selected disabled>اختر قسم</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}">{{ $lesson->name}} ({{ $lesson->section->name}})</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleFormControlSelect2" style="font-size:20px">نوع المدخلات</label>
                                    <select name="input_type" class="form-control" id="exampleFormControlSelect2">                                        
                                        <option selected disabled>اختر نوع</option>
                                        <option value="نص">نصي</option>
                                        <option value="صورة">صور</option>                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size:20px">نوع الاختبار</label>
                                    <div class="form-group">
                                        <input type="name" name="type" id="type" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">مدة الاختبار </label>
                                    <div class="form-group">
                                        <input type="name" name="time" id="time" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size:20px">عدد الاسئلة </label>
                                    <div class="form-group">
                                        <input type="name" name="question_num" id="question_num" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">عدد المحاولات </label>
                                    <div class="form-group">
                                        <input type="name" name="attempts" id="attempts" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size:20px">النقاط</label>
                                    <div class="form-group">
                                        <input type="name" name="points" id="points" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">الخصم لكل محاولة</label>
                                    <div class="form-group">
                                        <input type="name" name="deduction_per_attempt" id="deduction_per_attempt" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">الملاحظات</label>
                                    <div class="form-group">
                                        <input type="name" name="notes" id="notes" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_quiz2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_quiz" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit quiz --}}
    <div class="form-modal-ex">
        <div class="modal fade text-left" id="edit_quiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> تعديل اختبار</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit_quiz_form">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id2">
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">إسم الاختبار </label>
                                    <div class="form-group">
                                        <input type="name" name="name" id="name2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-6">
                                    <label style="font-size:20px">إسم الدرس</label>
                                    <select name="lesson_id" class="form-control" id="select2">
                                        <?php $lessons = \App\Models\Lesson::with('section')->get(); ?>
                                        
                                        <option selected disabled>اختر درس</option>
                                        @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}">{{ $lesson->name}} ({{ $lesson->section->name}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="select3" style="font-size:20px">نوع المدخلات</label>
                                    <select name="input_type" class="form-control" id="select3">
                                        <option value="نص">نصي</option>
                                        <option value="صورة">صور</option>                                        
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size:20px">نوع الاختبار</label>
                                    <div class="form-group">
                                        <input type="name" name="type" id="type2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">مدة الاختبار </label>
                                    <div class="form-group">
                                        <input type="name" name="time" id="time2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size:20px">عدد الاسئلة </label>
                                    <div class="form-group">
                                        <input type="name" name="question_num" id="question_num2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">عدد المحاولات </label>
                                    <div class="form-group">
                                        <input type="name" name="attempts" id="attempts2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="font-size:20px">النقاط</label>
                                    <div class="form-group">
                                        <input type="name" name="points" id="points2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label style="font-size:20px">الخصم لكل محاولة</label>
                                    <div class="form-group">
                                        <input type="name" name="deduction_per_attempt" id="deduction_per_attempt2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="font-size:20px">الملاحظات</label>
                                    <div class="form-group">
                                        <input type="name" name="notes" id="notes2" class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="edit_quiz2"
                                class="btn btn-primary btn-block">جاري التعديل ...</button>
                            <button type="button" id="edit_quiz1" class="btn btn-primary btn-block" onclick="do_edit()">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- delete quiz --}}
    <div class="modal fade modal-danger text-left" id="delete_quiz" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف الاختبار</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_quiz_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="delete_quiz2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                            <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_quiz_button" data-dismiss="modal">تأكيد</button>
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

{{-- add quiz --}}
<script>
    $(document).on('click', '#add_quiz', function(e) {
        $('#name_error').text('');


        $("#add_quiz2").css("display", "block");
        $("#add_quiz").css("display", "none");
        var formData = new FormData($('#add_quiz_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_quiz') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                $("#add_quiz2").css("display", "none");
                $("#add_quiz").css("display", "block");
                $('.close').click();
                // toastr.success('level added successfully.');
                $('#position-top-start').click(); // Trigger the button click
                $('#name').val('');
                $('#exampleFormControlSelect1').val('');
                $('#exampleFormControlSelect2').val('');
                $('#type').val('');
                $('#time').val('');
                $('#question_num').val('');
                $('#attempts').val('');
                $('#points').val('');
                $('#deduction_per_attempt').val('');
                $('#notes').val('');
            },

            error: function(reject) {
                $("#add_quiz2").css("display", "none");
                $("#add_quiz").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>

{{-- show quizzes --}}
<script type="text/javascript">

    $(function () {
        var table = $('#quizzes-table').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($lesson_id))
               ajax: "{{ route('get_quizzes_data',$lesson_id) }}",
            @else
               ajax: "{{ route('get_quizzes_data') }}",
            @endif
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'lesson', name:'lesson'},
                {data: 'input_type', name:'input_type'},
                {data: 'type', name : 'type'},
                {data: 'time', name : 'time'},
                {data: 'question_num', name : 'question_num'},
                {data: 'attempts', name : 'attempts'},
                {data: 'points', name : 'points'},
                {data: 'deduction_per_attempt', name : 'deduction_per_attempt'},
                {data: 'notes', name : 'notes'},
                {data: 'action',searchable:false},
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']], // page length options
        });
    });
    
    </script>

    {{-- edit lesson--}}
    <script>
        $('#edit_quiz').on('show.bs.modal', function(event) {
            var button     = $(event.relatedTarget)
            var id         = button.data('id')
            var name       = button.data('name')
            var lesson_id   = button.data('lesson_id')
            var type       = button.data('type')
            var input_type       = button.data('input_type')
            var time       = button.data('time')
            var question_num  = button.data('question_num')
            var attempts= button.data('attempts')
            var points       = button.data('points')
            var deduction_per_attempt       = button.data('deduction_per_attempt')
            var notes       = button.data('notes')
            var modal = $(this);
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #select2').val(lesson_id);
            modal.find('.modal-body #select3').val(input_type);
            modal.find('.modal-body #type2').val(type);
            modal.find('.modal-body #time2').val(time);
            modal.find('.modal-body #question_num2').val(question_num);
            modal.find('.modal-body #attempts2').val(attempts);
            modal.find('.modal-body #points2').val(points);
            modal.find('.modal-body #deduction_per_attempt2').val(deduction_per_attempt);
            modal.find('.modal-body #notes2').val(notes);
        
        });
    </script>
    
    <script>
        function do_edit(){
            $("#edit_quiz1").css("display", "none");
            $("#edit_quiz2").css("display", "block");
            var formData = new FormData($('#edit_quiz_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('edit_quiz')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#edit_quiz2").css("display", "none");
                    $("#edit_quiz1").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_edit').click();
                    $('#name2').val('');
                }, error: function (reject) {
                    $("#edit_quiz2").css("display", "none");
                    $("#edit_quiz1").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
                }
            });
    }
    </script>

    {{-- delete quiz--}}
    <script>
        $('#delete_quiz').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>
    <script>
        function do_delete(){
            $("#delete_quiz_button").css("display", "none");
            $("#delete_quiz2").css("display", "block");
            var formData = new FormData($('#delete_quiz_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('delete_quiz')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_quiz2").css("display", "none");
                    $("#delete_quiz_button").css("display", "block");
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
