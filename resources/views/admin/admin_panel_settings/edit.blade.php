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
                            {{-- --------------------------------------بيانات المقاسات والاسعار------------------------------------- --}}

                            <div class=" col-md-12 text-center">
                                <h4 class=" btn-info p-1">بيانات الشركة</h4>
                            </div>
                            <div class="row">


                                <div class="form-group col-3">
                                    <label>اسم الشركة</label>
                                    <input name="system_name" id="systm_name" class="form-control"
                                        value="{{ $data['system_name'] }}" placeholder="ادخل اسم الشركه">
                                    @error('system_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-5">
                                    <label>عنوان الشركة</label>
                                    <input name="address" id="address" class="form-control" value="{{ $data['address'] }}"
                                        placeholder="ادخل عنوان الشركه">
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-4">
                                    <label>هاتف الشركة</label>
                                    <input name="phone" id="phone" class="form-control" value="{{ $data['phone'] }}"
                                        placeholder="ادخل هاتف الشركه">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- --------------------------------------بيانات المقاسات والاسعار------------------------------------- --}}




                </div>


                <div class="col-md-12 text-center mb-2">
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
