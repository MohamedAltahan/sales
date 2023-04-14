@extends('layouts.admin')
@section('title', 'اضافة خزنة جديدة')

@section('contentheader')
    الخزن
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.create') }}"> الخزن </a>
@endsection

@section('contentheaderactive')
    اضافة
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة خزنه جديدة </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}

                    <form action="{{ route('admin.treasuries.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>اسم الخزنة</label>
                            <input name="name" value="{{ old('name') }}" id="name" class="form-control"
                                placeholder="ادخل اسم الخزنة">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>هل رئيسيه </label>
                            <select name="is_master" id="is_master" class="form-control">
                                <option value="">اختر النوع</option>
                                </option>
                                <option value="0" @if (old('is_master') == 0 and old('is_master') != '') selected= 'selected' @endif>لا
                                </option>
                                <option value="1" @if (old('is_master') == 1) selected= 'selected' @endif>نعم
                            </select>
                            @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>اخر رقم ايصال صرف نقدية </label>
                            <input value="{{ old('last_bill_exchange') }}"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_bill_exchange"
                                id="last_bill_exchange" class="form-control" placeholder="ادخل اخر رقم ايصال صرف نقدية ">
                            @error('last_bill_exchange')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>اخر رقم ايصال تحصيل نقدية </label>
                            <input value="{{ old('last_bill_collect') }}"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="last_bill_collect"
                                id="last_bill_collect" class="form-control" placeholder="ادخل اخر رقم ايصال تحصيل نقدية  ">
                            @error('last_bill_collect')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>حالة التفعيل </label>

                            <select name="active" id="active" class="form-control">

                                <option value="">اختر الحالة</option>
                                <option selected value="1"
                                    @if (old('active') == 1) selected= 'selected' @endif>مفعل</option>
                                <option value="0" @if (old('active') == 0 and old('active') != '') selected= 'selected' @endif>غيرمفعل
                                </option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button button class="btn btn-lg btn-success">إضافة </button>
                            <a href="{{ route('admin.treasuries.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                        </div>
                    </form>

                </div>
                {{-- card body end --}}
            </div>
            {{-- card end --}}




        </div>
    </div>

@endsection
