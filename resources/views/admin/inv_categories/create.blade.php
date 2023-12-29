@extends('layouts.admin')
@section('title', ' ضبط المخازن')
@section('contentheader', ' الاصناف ')
@section('contentheaderlink')
    <a href="{{ route('admin.items.index') }}">الاصناف </a>
@endsection
@section('contentheaderactive', ' اضافة ')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة فئة جديدة </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}

                    <form action="{{ route('inv_categories.store') }}" method="post" >
                        @csrf
                        <div class="form-group">
                            <label>اسم الفئة </label>
                            <input name="name" value="{{ old('name') }}" id="name" class="form-control"
                                placeholder="ادخل اسم الفئة">
                            @error('name')
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
                            <a href="{{ route('inv_categories.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                        </div>
                    </form>

                </div>
                {{-- card body end --}}
            </div>
            {{-- card end --}}




        </div>
    </div>

@endsection
