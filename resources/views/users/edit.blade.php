@extends('layouts.master')
@section('css')
<!-- Internal Nice-select css  -->
<link href="{{URL::asset('assets/plugins/jquery-nice-select/css/nice-select.css')}}" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://troodon.mirmaz-apps.com/app-assets/vendors/css/forms/select/select2.min.css">

@section('title')
تعديل مستخدم - مورا سوفت للادارة القانونية
@stop


@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                مستخدم</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-lg-12 col-md-12">

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

        <div class="card">
            <div class="card-body">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-primary btn-sm" href="{{ route('show_users') }}">رجوع</a>
                    </div>
                </div><br>

                {!! Form::model($user, ['method' => 'POST','route' => ['update_user']]) !!}
                <div class="">

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6" id="fnWrapper">
                            <label>اسم المستخدم: <span class="tx-danger">*</span></label>
                            {!! Form::hidden('id', $user->id) !!}
                            {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                        </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                            <label>البريد الالكتروني: <span class="tx-danger">*</span></label>
                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        </div>
                    </div>

                </div>

                <div class="row mg-b-20">
                    <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label>كلمة المرور: <span class="tx-danger">*</span></label>
                        {!! Form::password('password', array('class' => 'form-control','required')) !!}
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <label>نوع المستخدم</label>
                            <div class="form-group">
                                        
                                {{-- <select class="form-select form-control" size="3" name="roles_name" id="roles_name" aria-label=".form-select-lg example"> --}}
                                    <select multiple class="select2 form-control" name="roles_name[]" id="roles_name" aria-label=".form-select-lg example">

                                        <option disabled>-------</option>
                                        <?php  $m = Spatie\Permission\Models\Role::all();?>
                                    
                                        @foreach ($m as $n)

                                        <option value="{{ $n->name }}">{{ $n->name }}</option>
                                            
                                        @endforeach

                                 </select>
                                <span id="roles_name_error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                        <label> تاكيد كلمة المرور: <span class="tx-danger">*</span></label>
                        {!! Form::password('confirm-password', array('class' => 'form-control','required')) !!}
                    </div> --}}
                </div>

                <div class="row row-sm mg-b-20">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <label class="form-label">حالة المستخدم</label>
                        <select name="status" id="select-beast" class="form-control  nice-select  custom-select">
                            <option value="{{ $user->status}}">{{ $user->status}}</option>
                            <option value="مفعل">مفعل</option>
                            <option value="غير مفعل">غير مفعل</option>
                        </select>
                    </div>
                

                    
                </div>
                <br>
                <div class="mg-t-30">
                    <button class="btn btn-primary pd-x-20" type="submit">تحديث</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>




</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('scripts')

<script src="https://troodon.mirmaz-apps.com/app-assets/vendors/js/forms/select/select2.full.min.js"></script>

<!-- Internal Nice-select js-->
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/jquery.nice-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery-nice-select/js/nice-select.js')}}"></script>

<script src="https://troodon.mirmaz-apps.com/app-assets/js/scripts/forms/form-select2.js"></script>


<!--Internal  Parsley.min js -->
<script src="{{URL::asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
<!-- Internal Form-validation js -->
<script src="{{URL::asset('assets/js/form-validation.js')}}"></script>
@endsection