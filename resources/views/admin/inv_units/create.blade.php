@extends('layouts.admin')
@section('title', ' الوحدات')
@section('contentheader', ' الوحدات ')

@section('contentheaderlink')
    <a href="{{ route('admin.units.index') }}">الوحدات </a>
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة وحدة صنف جديد  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    <form action="{{ route('admin.units.store') }}" method="post" >
                        @csrf
                        <div class="form-group">
                            <label>اسم الوحدة</label>
                            <input name="name" value="{{ old('name') }}" id="name" class="form-control"
                                placeholder="ادخل اسم الوحدة">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label> نوع الوحدة </label>

                            <select name="is_master" id="is_master" class="form-control">
                                <option value="">اختر النوع</option>
                                <option  value="1"
                                    @selected(old('is_master') == 1)>واحدة اساسية</option>
                                <option value="0"
                                    @selected (old('is_master') == 0 and old('is_master') != '')>وحدة تجزئة</option>
                            </select>

                            @error('is_master')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>حالة التفعيل </label>

                            <select name="active" id="active" class="form-control">
                                <option value="">اختر الحالة</option>
                                <option  value="1"
                                    @selected(old('active') == 1)>مفعل</option>
                                <option value="0"
                                    @selected (old('active') == 0 and old('active') != '')>غيرمفعل</option>
                            </select>

                            @error('active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="text-center">
                            <button button class="btn btn-lg btn-success"> إضافة </button>
                            <a href="{{ route('admin.units.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                        </div>
                    </form>

                </div>
                {{-- card body end --}}
            </div>
            {{-- card end --}}




        </div>
    </div>

@endsection
