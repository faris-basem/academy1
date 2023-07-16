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

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">إضافة أجوبة</a>

    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">الأجوبة</h4>
                </div>
                <div class="table-responsive">
                    <table class="table yajra-datatable" id="answers-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاجابة</th>
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

    {{-- add answer --}}
    <div class="form-modal-ex" id="modal_add">
        <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> إضافة أجوبة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add_answer_form" class="invoice-repeater">
                        @csrf
                        <div class="modal-body">
                            <div data-repeater-list="answers">
                                <div data-repeater-item>
                                    <div class="row d-flex align-items-end">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="question"> الاجابة</label>
                                                <?php
                                                    $ques = \App\Models\Question::where('id',$question_id)->first();
                                                    $quiz = \App\Models\Quiz::where('id',$ques->quiz_id)->first();
                                                    if ($quiz->input_type=='نص') {
                                                        ?>
                                                        <input type="text" class="form-control" id="answer" name="answer" />
                                                        <?php   
                                                    } else {
                                                        ?>
                                                        <input type="file" class="form-control" id="answer" name="answer" />
                                                        <?php
                                                    }
                                                    ?>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="status"> الحالة</label>
                                                <select name="status" class="form-control" id="status">
                                                    <option selected disabled>اختر حالة</option>
                                                        <option value="1">صحيحة</option>
                                                        <option value="0">خاطئة</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                                    <i data-feather="x" class="mr-25"></i>
                                                    <span>حذف</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                        <i data-feather="plus" class="mr-25"></i>
                                        <span>اضافة اجابة</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="add_answer2"
                                class="btn btn-primary btn-block">جاري الإضافة ...</button>
                            <button type="button" id="add_answer" class="btn btn-primary btn-block">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- edit answer --}}
    <div class="form-modal-ex">
        <div class="modal fade text-left" id="edit_answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel33"> تعديل اجابة</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit_answer_form">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id2">
                            <div class="row">
                                <div class="col-md-10">
                                    <label style="font-size:20px"> الاجابة </label>
                                    <div class="form-group">
                                        <?php
                                            $ques = \App\Models\Question::where('id',$question_id)->first();
                                            $quiz = \App\Models\Quiz::where('id',$ques->quiz_id)->first();
                                            if ($quiz->input_type=='نص') {
                                        ?>
                                                <input type="text" class="form-control" id="answer2" name="answer" />
                                        <?php   
                                            } else {
                                        ?>
                                                <input type="file" class="form-control" id="answer3" name="answer" />
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status"> الحالة</label>
                                        <select name="status" class="form-control" id="status2">
                                            <option selected disabled>اختر حالة</option>
                                                <option value="1">صحيحة</option>
                                                <option value="0">خاطئة</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="display: none" id="edit_answer2"
                                class="btn btn-primary btn-block">جاري التعديل ...</button>
                            <button type="button" id="edit_answer1" class="btn btn-primary btn-block" onclick="do_edit()">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- delete answer --}}
    <div class="modal fade modal-danger text-left" id="delete_answer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">حذف الدرس</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="delete_answer_form">
                        @csrf
                        <input type="hidden" name="id" id="id3">
                        هل انت متأكد من عملية الحذف ؟
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="delete_answer2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                            <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_answer_button" data-dismiss="modal">تأكيد</button>
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

{{-- add answer --}}
<script>
    $(document).on('click', '#add_answer', function(e) {
        $('#file_name_error').text('');
       


        $("#add_answer2").css("display", "block");
        $("#add_answer").css("display", "none");
        var formData = new FormData($('#add_answer_form')[0]);
        $.ajax({
            type: 'post',
            enctype: 'multipart/form-data',
            url: "{{ route('store_answer',['question_id'=>$question_id]) }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
                $("#add_answer2").css("display", "none");
                $("#add_answer").css("display", "block");
                $('.close').click();
                // toastr.success('level added successfully.');
                $('#position-top-start').click(); // Trigger the button click
                $('#answer').val('');
                $('#exampleFormControlSelect1').val('');
                
            },

            error: function(reject) {
                $("#add_answer2").css("display", "none");
                $("#add_answer").css("display", "block");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
</script>

{{-- show answers --}}
<script type="text/javascript">

    $(function () {
        var table = $('#answers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_answers_data',$question_id) }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'answer', name: 'answer'},
                {data: 'status', name:'status'},
                {data: 'action',searchable:false},
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']], // page length options
        });
    });
    
    </script>

    {{-- edit answer--}}
    <script>
        $('#edit_answer').on('show.bs.modal', function(event) {
            var button     = $(event.relatedTarget)
            var id         = button.data('id')
            var answer       = button.data('answer')
            var status   = button.data('status')
            var modal = $(this);
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #answer2').val(answer);
            modal.find('.modal-body #status2').val(status);
            
        });
    </script>
    
    <script>
        function do_edit(){
            $("#edit_answer1").css("display", "none");
            $("#edit_answer2").css("display", "block");
            var formData = new FormData($('#edit_answer_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('edit_answer')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#edit_answer2").css("display", "none");
                    $("#edit_answer1").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_edit').click();
                    $('#answer2').val('');
                    $('#answer3').val('');
                    $('#select2').val('');
                }, error: function (reject) {
                    $("#edit_answer2").css("display", "none");
                    $("#edit_answer1").css("display", "block");


                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);

                });
                }
            });
    }
    </script>

    {{-- delete answer--}}
    <script>
        $('#delete_answer').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>
    <script>
        function do_delete(){
            $("#delete_answer_button").css("display", "none");
            $("#delete_answer2").css("display", "block");
            var formData = new FormData($('#delete_answer_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('delete_answer')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $("#delete_answer2").css("display", "none");
                    $("#delete_answer_button").css("display", "block");
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



    {{-- <script src="{{asset('/app-assets/vendors/js/vendors.min.js')}}"></script> --}}
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('/app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('/app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

@endsection
