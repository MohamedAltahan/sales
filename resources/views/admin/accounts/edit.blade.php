@extends('layouts.admin')
@section('title', 'تعديل حساب مالي')
@section('contentheader', ' الحسابات المالية ')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الحسابات المالية </a>
@endsection

@section('content')

    {{-- =======================================start of the big card========================================== --}}
    <div class="row ">
        <div class="col-12">
            <div class="card pb-4">
                {{-- cardheader --}}
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل حساب مالي </h3>
                </div>

                <div class="card-body">
                    {{-- $data['id'] is to send the 'id' to the update function in the controller --}}
                    <form action="{{ route('admin.accounts.update', $data->id) }}" method="post">
                        @csrf
                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card pr-4 pb-3">
                            <div class="row ">

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> اسم الحساب المالي </label>
                                        <input name="name" value="{{ old('name', $data['name']) }}" id="name"
                                            class="form-control" placeholder="ادخل الاسم ">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 ">
                                    <label> نوع الحساب</label>
                                    <select name='account_type_id' id='account_type_id' class="form-control">
                                        <option value=''>اختار النوع</option>
                                        {{-- isset check if the variable isn't null --}}
                                        @if (@isset($account_types) && !@empty($account_types))
                                            @foreach ($account_types as $info)
                                                {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                {{-- 'account_type_id' is the 'name' of the current select input --}}
                                                {{-- $data['account_type_id'] is the data come from database when the user click on edit the item --}}
                                                <option @selected(old('account_type_id', $data['account_type_id']) == $info->id) value="{{ $info->id }}">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('account_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-5">
                                    <div class="form-group">
                                        <label>هل الحساب اساسي </label>
                                        <select name="is_primary" id="is_primary" class="form-control">
                                            <option value="0" @selected(old('is_primary', $data['is_primary']) == 0) selected>لا</option>
                                            <option value="1" @selected(old('is_primary', $data['is_primary']) == 1)>نعم </option>
                                        </select>
                                        @error('is_primary')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 " id="primary_div" style="display:none">
                                    <label> الحسابات الاساسية</label>

                                    <div>

                                        <select name='primary_accounts' id='primary_accounts' class="form-control">
                                            <option value="">اختار الحساب الاساسي</option>
                                            {{-- isset check if the variable isn't null --}}

                                            @if (@isset($primary_accounts) && !@empty($primary_accounts))
                                                @foreach ($primary_accounts as $info)
                                                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                    <option @selected(old('primary_accounts', $data['primary_account_number']) == $info->id) value="{{ $info->id }}">
                                                        {{ $info->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('primary_accounts')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> حالة الرصيد اول المدة </label>
                                        <select name="start_balance_status" id="start_balance_status" class="form-control">
                                            <option value="0" @selected(old('start_balance_status', $data['start_balance_status']) == 0) selected>متزن</option>
                                            <option value="1" @selected(old('start_balance_status', $data['start_balance_status']) == 1)>دائن</option>
                                            <option value="2" @selected(old('start_balance_status', $data['start_balance_status']) == 2)>مدين</option>
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
                                            value="{{ old('start_balance', $data['start_balance']) }}" id="start_balance"
                                            class="form-control" placeholder="ادخل الرصيد اول المدة ">
                                        @error('start_balance')
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
                                            <option value="0" @selected(old('active', $data['active']) == 0)>غير مفعل</option>
                                            <option value="1" @selected(old('active', $data['active']) == 1)>مفعل</option>
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
                    <a href="{{ route('admin.accounts.index') }}" class="btn btn-lg btn-danger">الغاء</a>
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
