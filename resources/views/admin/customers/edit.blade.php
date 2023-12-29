@extends('layouts.admin')
@section('title', 'تعديل بيانات عميل')
@section('contentheader', ' ضبط المخازن ')
@section('contentheaderlink')
    <a href="{{ route('admin.customers.index') }}">العملاء </a>
@endsection


@section('content')
    {{-- =======================================start of the big card========================================== --}}
    <div class="row ">
        <div class="col-12">
            <div class="card pb-4">
                {{-- cardheader --}}
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل بيانات عميل </h3>
                </div>

                <div class="card-body">
                    {{-- $data['id'] is to send the 'id' to the update function in the controller --}}
                    <form action="{{ route('admin.customers.update', $data->id) }}" method="post">
                        @csrf
                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card pr-4 pb-3">
                            <div class="row ">

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> اسم العميل </label>
                                        <input name="name" value="{{ old('name', $data['name']) }}" id="name"
                                            class="form-control" placeholder="ادخل الاسم ">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> العنوان </label>
                                        <input name="address" value="{{ old('address', $data['address']) }}" id="address"
                                            class="form-control" placeholder="ادخل الملاحظات ">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> ملاحظات </label>
                                        <input name="notes" value="{{ old('notes', $data['notes']) }}" id="notes"
                                            class="form-control" placeholder="ادخل الملاحظات ">
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-5">
                                    <div class="form-group">
                                        <label>حالة التفعيل </label>
                                        <select name="active" id="active" class="form-control">
                                            <option value="1" @selected(old('active', $data['active']) == 1)>مفعل</option>
                                            <option value="0" @selected(old('active', $data['active']) == 0)> غير مفعل</option>
                                        </select>
                                        @error('active')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- first row class end --}}
                            </div>
                            {{-- first card end --}}
                        </div>
                        {{-- ============================================end of the first card============================================ --}}

                        {{-- big 'cardbody' end --}}
                </div>

                <div class="text-center">
                    <button button class="btn btn-lg btn-success"> تعديل </button>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                </div>
                </form>

                {{-- big 'card' end --}}
            </div>
            {{-- big 'col-12' cladd end --}}
        </div>
        {{-- big 'row' class end --}}
    </div>

@endsection



@section('script')
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection
