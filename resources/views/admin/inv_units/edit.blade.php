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
                    <h3 class="card-title card_title_center"> تعديل بيانات الوحدة  </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))
                        <form action="{{ route('admin.units.update', $data['id']) }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>اسم الوحدة </label>
                                <input name="name"  value="{{ old('name', $data['name']) }}"
                                    id="name" class="form-control" placeholder="ادخل اسم الوحدة">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label>نوع الوحدة  </label>

                                <select name="is_master" id="is_master" class="form-control">

                                    <option @selected(old('is_master') == 1) value="1">
                                        اساسية</option>

                                    <option @selected(old('is_master') == 0) value="0">
                                        فرعية</option>
                                </select>

                                @error('is_master')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>حالة التفعيل </label>

                                <select name="active" id="active" class="form-control">

                                    <option @selected(old('active') == 1) value="1">
                                        مفعل</option>

                                    <option @selected(old('active') == 0) value="0">
                                        غيرمفعل
                                    </option>
                                </select>

                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center">
                                <button button class="btn btn-lg btn-success">تعديل</button>
                                <a href="{{ route('admin.units.index') }}" class="btn btn-lg btn-danger">الغاء</a>

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
