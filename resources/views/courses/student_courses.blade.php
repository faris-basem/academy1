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


    <div class="row" id="basic-table">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">كورسات الطالب</h4>
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
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')

{{-- show courses --}}
<script type="text/javascript">

    $(function () {
        var table = $('#courses-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student_courses_data', ['user_id' => $user_id]) }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name'},
                {data: 'level', name:'level'},
                {data: 'sections', name : 'sections'},
                {data: 'img', name : 'img'},
                {data: 'description', name : 'description'},
                {data: 'type', name : 'type'},
            ],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, 'All']], // page length options
        });
    });
    
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
