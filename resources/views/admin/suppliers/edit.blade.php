@extends('layouts.admin')
@section('title', 'الموردين')
@section('contentheader', 'الحسابات')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الموردين </a>
@endsection


@section('content')
    {{-- =======================================start of the big card========================================== --}}
    <div class="row ">
        <div class="col-12">
            <div class="card pb-4">
                {{-- cardheader --}}
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل بيانات مورد </h3>
                </div>

                <div class="card-body">
                    {{-- $data['id'] is to send the 'id' to the update function in the controller --}}
                    <form action="{{ route('admin.suppliers.update', $data->id) }}" method="post">
                        @csrf
                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card pr-4 pb-3">
                            <div class="row ">

                                <div class=" col-5 ">
                                    <div class="form-group">
                                        <label> اسم المورد </label>
                                        <input name="name" value="{{ old('name', $data['name']) }}" id="name"
                                            class="form-control" placeholder="ادخل الاسم ">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-5 ">
                                    <label> اختار نوع المورد</label>
                                    <select name='supplier_type_id' class="form-control">
                                        <option value="">اختار نوع المورد</option>
                                        {{-- isset check if the variable isn't null --}}
                                        @if (@isset($supplier_type_id) && !@empty($supplier_type_id))
                                            @foreach ($supplier_type_id as $info)
                                                {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                <option @selected(old('supplier_type_id', $data->supplier_type_id) == $info->id) value="{{ $info->id }}">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('supplier_type_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection
