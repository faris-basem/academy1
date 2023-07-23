@extends('layouts.master')
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@section('title')
اضافة الصلاحيات - مورا سوفت للادارة القانونية
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الصلاحيات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة
                نوع مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>خطا</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif




{!! Form::open(array('route' => 'store_role','method'=>'POST')) !!}
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="col-xs-7 col-sm-7 col-md-7">
                        <div class="form-group">
                            <p>اسم الصلاحية :</p>
                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                        </div>
                    </div>
                </div>
               
                        <ul id="treeview1">
                            <li><a href="#">الصلاحيات</a>
                                <ul>
                            </li>
                            <div class="row">
                            @foreach($permission as $value)

                          
                                @if($value->parent == 0)
                                <div class="col-md-4" style="border-style: ridge;padding:2%">
                             


                                    <label style="font-size: 16px;font-size:30px">
                                        {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }} {{ $value->name }}
                                    </label>
                                    <br> <br>

                                    <?php $permissions_chi = \App\Models\Permission::where('parent',$value->id)->get();?>
                                    @foreach($permissions_chi as $permissions_ch)

                                   
                                    <div style="margin-right:8%">
                                        <label style="font-size: 16px;color:black">
                                            {{ Form::checkbox('permission[]', $permissions_ch->id, false, array('class' => 'name')) }} {{ $permissions_ch->name }}
                                        </label>
                                    </div>

                                    
                                    @endforeach
                                
                                    <br>


                               
                                

                                </div>
                                @endif
                                
                           
                                @endforeach
                                
                            </div>
                            </li>

                        </ul>
                        </li>
                        </ul>
                    </div>
                    <!-- /col -->
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-main-primary">تاكيد</button>
                    </div>

                </div>
        
    </div>

</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->

{!! Form::close() !!}
@endsection
@section('js')
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
@endsection