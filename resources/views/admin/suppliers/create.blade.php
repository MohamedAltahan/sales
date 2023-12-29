@extends('layouts.admin')
@section('title', 'الموردين')
@section('contentheader', 'الحسابات')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الموردين </a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

    {{-- =======================================start of the big card========================================== --}}
    <div class="row ">
        <div class="col-12">
            <div class="card pb-4">
                {{-- cardheader --}}
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة حساب مورد جديد </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.suppliers.store') }}" method="post">
                        @csrf
                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card pr-4 pb-3">
                            <div class="row ">

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> اسم المورد </label>
                                        <input autofocus name="name" value="{{ old('name') }}" id="name"
                                            class="form-control" placeholder="ادخل الاسم ">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 ">
                                    <label>اختار نوع المورد</label>
                                    <select name='supplier_type_id' class="form-control select2">
                                        <option value="">اختار نوع المورد</option>
                                        {{-- isset check if the variable isn't null --}}
                                        @if (@isset($supplier_type_id) && !@empty($supplier_type_id))
                                            @foreach ($supplier_type_id as $info)
                                                {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                <option @selected(old('supplier_type_id') == $info->id) value="{{ $info->id }}">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('supplier_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> حالة الرصيد اول المدة </label>
                                        <select name="start_balance_status" id="start_balance_status" class="form-control">
                                            <option value="0" @selected(old('start_balance_status') == 0) selected>متزن</option>
                                            <option value="1" @selected(old('start_balance_status') == 1)>دائن</option>
                                            <option value="2" @selected(old('start_balance_status') == 2)>مدين</option>
                                        </select>
                                        @error('start_balance_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> رصيد اول المدة للحساب</label>
                                        <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="start_balance"
                                            value="{{ old('start_balance', 0) }}" id="start_balance" class="form-control"
                                            placeholder="ادخل الرصيد اول المدة ">
                                        @error('start_balance')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label>العنوان </label>
                                        <input name="address" value="{{ old('address') }}" id="address"
                                            class="form-control" placeholder="ادخل العنوان ">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> ملاحظات </label>
                                        <input type="text" name="notes" value="{{ old('notes') }}" id="notes"
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
                                            <option value="0" @selected(old('active') == 0)>غير مفعل</option>
                                            <option selected value="1" @selected(old('active') == 1)> مفعل</option>

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
                    <button button class="btn btn-lg btn-success"> إضافة </button>
                    <a href="{{ route('admin.suppliers.index') }}" class="btn btn-lg btn-danger">الغاء</a>
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
    <script src="{{ asset('assets/admin/js/customers.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>
@endsection
