@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
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
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>

@endsection
