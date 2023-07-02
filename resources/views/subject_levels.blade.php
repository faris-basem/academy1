@extends('layouts.master')

@section('css')
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
<div class="btn btn-primary"><a style="color: white" href="">add</a></div>

<div class="row" id="basic-table">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">المراحل</h4>
            </div>
            <div class="table-responsive">
                <table class="table yajra-datatable" id="levels-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>courses</th>
                            <th>action</th>
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

<script type="text/javascript">

    $(function () {
        var table = $('#levels-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_subjects_data') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false,
                    render: function (data, type, row, meta) {
                        // Auto-increment the ID column starting from 1
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {data: 'name', name: 'name'},
                {data: 'courses',name:'courses',
                    render:function(data,type,row){
                        var sub=row.id
                        return '<a href="subject_levels/'+sub+'"calss="levels-link">'+data+'</a>';
                }},
                {data: 'action'},
                //{data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, 'All']], // page length options
        });
    });
    
    </script>
    
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
