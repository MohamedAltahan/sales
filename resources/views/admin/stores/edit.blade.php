@extends('layouts.admin')
@section('title', ' تعديل بيانات المخازن ')
@section('contentheader','المخازن ' )

@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}"> المخازن  </a>
@endsection
@section('contentheaderactive')
    تعديل
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل بيانات المخزن  </h3>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))
                        <form action="{{ route('admin.stores.update', $data['id']) }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label>اسم المخزن </label>
                                <input name="name"  value="{{ old('name', $data['name']) }}"
                                    id="name" class="form-control" placeholder="ادخل اسم المخزن">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>هاتف المخزن </label>
                                <input name="phone" value="{{ old('phone', $data['phone']) }}" id="phone" class="form-control"
                                    placeholder="ادخل هاتف المخزن">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>عنوان المخزن</label>
                                <input name="address" value="{{ old('address', $data['address']) }}" id="address" class="form-control"
                                    placeholder="ادخل  العنوان">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>حالة التفعيل </label>

                                <select name="active" id="active" class="form-control">

                                    <option @selected(old('active',$data['active']) == 1) value="1">
                                        مفعل</option>

                                    <option @selected(old('active',$data['active']) == 0) value="0">
                                        غيرمفعل
                                    </option>
                                </select>

                                @error('active')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 text-center">
                                <button button class="btn btn-lg btn-success">تعديل</button>
                                <a href="{{ route('admin.sales_matrial_types.index') }}" class="btn btn-lg btn-danger">الغاء</a>

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
