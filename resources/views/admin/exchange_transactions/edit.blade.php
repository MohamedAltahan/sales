@extends('layouts.admin')
@section('title', ' تعديل بيانات الخزنة')

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection

@section('contentheaderactive')
    تعديل
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل بيانات خزنة </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))
                        <form action="{{ route('admin.treasuries.update', $data['id']) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label>اسم الخزنة</label>
                                <input name="name" {{-- isset >>is used to determine if the value is differnt from null --}} value="{{ old('name', $data['name']) }}"
                                    id="name" class="form-control" placeholder="ادخل اسم الخزنة">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>هل رئيسيه </label>
                                <select name="is_master" id="is_master" class="form-control">
                                    <option value="">اختر النوع</option>
                                    </option>
                                   {{-- if the old value after submit or the value when you visit the page for the first time is ='1' --}}
                                    <option  @if (old('is_master',$data['is_master']) == 1) selected= 'selected' @endif value="1">
                                        نعم
                                    </option>
                                   {{-- if the old value after submit or the value when you visit the page for the first time is ='0' --}}
                                    <option @if (old('is_master',$data['is_master']) == 0) selected= 'selected' @endif value="0">لا
                                    </option>

                                </select>
                                @error('is_master')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>اخر رقم ايصال صرف نقدية </label>
                                <input value="{{ old('last_bill_exchange', $data['last_bill_exchange']) }}"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_bill_exchange"
                                    id="last_bill_exchange" class="form-control"
                                    placeholder="ادخل اخر رقم ايصال صرف نقدية ">
                                @error('last_bill_exchange')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>اخر رقم ايصال تحصيل نقدية </label>
                                <input value="{{ old('last_bill_collect', $data['last_bill_collect']) }}"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_bill_collect"
                                    id="last_bill_collect" class="form-control"
                                    placeholder="ادخل اخر رقم ايصال تحصيل نقدية  ">
                                @error('last_bill_collect')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>حالة التفعيل </label>

                                <select name="active" id="active" class="form-control">

                                   {{-- if the old value after submit or the value when you visit the page for the first time is ='1' --}}
                                    <option @if (old('active',$data['active']) == 1) selected= 'selected' @endif value="1">
                                        مفعل</option>
                                   {{-- if the old value after submit or the value when you visit the page for the first time is ='0' --}}
                                    <option @if (old('active',$data['active']) == 0) selected= 'selected' @endif value="0">
                                        غيرمفعل
                                    </option>

                                </select>

                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center">
                                <button button class="btn btn-lg btn-success">تعديل</button>
                                <a href="{{ route('admin.treasuries.index') }}" class="btn btn-lg btn-danger">الغاء</a>

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
