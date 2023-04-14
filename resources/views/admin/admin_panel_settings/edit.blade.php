@extends('layouts.admin')
@section('title', ' تعديل الضبط العام')

@section('contentheader')
    الضبط
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsetting.index') }}"> الضبط </a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل بيانات الضبط العام </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))
                        <form action="{{ route('admin.adminpanelsetting.update') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>اسم الشركة</label>
                                <input name="system_name" id="systm_name" class="form-control"
                                    value="{{ $data['system_name'] }}" placeholder="ادخل اسم الشركه">
                                @error('system_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>عنوان الشركة</label>
                                <input name="address" id="address" class="form-control" value="{{ $data['address'] }}"
                                    placeholder="ادخل عنوان الشركه">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>هاتف الشركة</label>
                                <input name="phone" id="phone" class="form-control" value="{{ $data['phone'] }}"
                                    placeholder="ادخل هاتف الشركه">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>رساله تنبيه اعلى الشاشه </label>
                                <input name="general_alert" id="general_alert" class="form-control"
                                    value="{{ $data['general_alert'] }}" placeholder="رساله تنبيه اعلى الشاشه ">
                            </div>

                            <div class="form-group">
                                <label> شعار الشركه</label>
                                <div>
                                    <img class="custom_img" src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}"
                                        alt="لوجو">
                                    {{-- <button type="button" class="btn btn-sm btn-danger" id="update_image">تغير
                                        الصوره</button>
                                    <button type="button" class="btn btn-sm btn-danger" style="display: none"
                                        id="cancel_update_image">الغاء</button> --}}
                                </div>
                            </div>
                            <div id='oldimage'>
                                '<br> <input type="file" class="form-control" name="photo" id="photo"
                                    class="btn btn-sm btn-danger">'
                            </div>
                </div>


                <div class="col-md-12 text-center">
                    <button button class="btn btn-lg btn-success">تعديل</button>
                </div>
                </form>
            @else
                <div class="alert alert-danger">
                    لا يوجد بيانات
                </div>
                @endif

            </div>
        </div>




    </div>
    </div>

@endsection
