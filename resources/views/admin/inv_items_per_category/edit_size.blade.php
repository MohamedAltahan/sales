@extends('layouts.admin')
@section('title', 'تعديل صنف ')
@section('contentheader', 'الاصناف')
@section('contentheaderlink')
    <a href="{{ route('admin.items.index') }}"> الاصناف </a>
@endsection
@section('contentheaderactive')
    تعديل صنف
@endsection

@section('content')
    {{-- =======================================start of the big card========================================== --}}
    <div class="row ">
        <div class="col-12">
            <div class="card pb-4">
                {{-- cardheader --}}
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تعديل مقاس صنف </h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.items.update_size', $sizeData->id) }}" method="post">
                        @csrf
                        {{-- @dd($data) --}}
                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card pr-4 pb-3 pt-3">

                            <div class="row">

                                <div class="form-group col-12">
                                    <label> الاسم التعريفي للمقاس</span></label>
                                    <input name="name" id="name" class="form-control"
                                        value="{{ old('name', $sizeData['name']) }}" placeholder="ادخل الاسم التعريفي">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label> العرض <span style="color: red">بالسم</span></label>
                                    <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="width"
                                        id="width" class="form-control" value="{{ old('width', $sizeData['width']) }}"
                                        placeholder="ادخل الطول بالسم">
                                    @error('width')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label> الطول <span style="color: red">بالسم</span></label>
                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" name="length"
                                        id="length" class="form-control"
                                        value="{{ old('length', $sizeData['length'] * 1) }}" placeholder="ادخل الطول بالسم">
                                    @error('length')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-3">
                                    <label> سعر المتر <span style="color: red">بالجنية</span></label>

                                    <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                        name="primary_retail_price" id="primary_retail_price" class="form-control"
                                        value="{{ old('primary_retail_price', $sizeData['primary_retail_price'] * 1) }}"
                                        placeholder="ادخل السعر ">
                                    @error('primary_retail_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class=" col-3 ">
                                    <label> وحدة القياس </label>
                                    <select name='primary_unit_id' id='primary_unit_id' class="form-control">
                                        <option value="">اختار الوحد </option>
                                        {{-- isset check if the variable isn't null --}}
                                        @if (@isset($units) && !@empty($units))
                                            @foreach ($units as $info)
                                                {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                <option @selected(old('primary_unit_id', $sizeData['primary_unit_id']) == $info->id) value="{{ $info->id }}">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('primary_unit_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class=" col-3 ">
                                    <label> العدد المتاح بالمخزن </label>
                                    <select name='item_stock_type' id='item_stock_type' class="form-control">
                                        <option @selected(old('item_stock_type', $sizeData['item_stock_type']) == 1) value="1"> العدد مفتوح </option>
                                        <option @selected(old('item_stock_type', $sizeData['item_stock_type']) == 2) value="2"> عدد محدود </option>
                                    </select>
                                    @error('item_stock_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div id="inStockInput" class="col-4"
                                    @if ($sizeData['item_stock_type'] == 1) style="display: none" @endif>
                                    <label> ادخل الكمية </label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                        value="{{ old('stock_quantity', $sizeData['stock_quantity']) }}"
                                        placeholder="ادخل الكمية المتاحة بالمخزن"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>

                                {{--  second row end --}}
                            </div>

                        </div>
                        {{-- ============================================end of the first card============================================ --}}


                </div>

                <div class="text-center">
                    <button button class="btn btn-lg btn-success"> تعديل </button>
                    <a href="{{ route('admin.items.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                </div>
                </form>

                {{-- big 'card' end --}}
            </div>
            {{-- big 'col-12' cladd end --}}
        </div>
        {{-- big 'row' class end --}}
    </div>


@endsection

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#uploadedImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0])
        }
    }
</script>


@section('script')
    <script src="{{ asset('assets/admin/js/inv_items.js') }}"></script>

@endsection
