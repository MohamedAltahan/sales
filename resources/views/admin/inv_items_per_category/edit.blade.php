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
                    <h3 class="card-title card_title_center"> تعديل صنف</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.items.update', $itemsData->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card pr-4 pb-3">
                            <div class="row ">

                                <div class=" col-7 ">
                                    <div class="form-group">
                                        <label> اسم الصنف </label>
                                        <input name="name" value="{{ old('name', $itemsData['name']) }}" id="name"
                                            class="form-control" placeholder="ادخل اسم الصنف">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-7 ">
                                    <label> وحدة القياس </label>
                                    <select name='primary_unit_id' id='primary_unit_id' class="form-control">
                                        <option value="">اختار الوحد </option>
                                        {{-- isset check if the variable isn't null --}}
                                        @if (@isset($inv_units_primary) && !@empty($inv_units_primary))
                                            @foreach ($inv_units_primary as $info)
                                                {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                <option @selected(old('primary_unit_id', $itemsData['primary_unit_id']) == $info->id) value="{{ $info->id }}">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('primary_unit_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class=" col-7 ">
                                    <div class="form-group">
                                        <label> سعر البيع </label>
                                        <input
                                            value="{{ old('primary_retail_price', 1 * $itemsData['primary_retail_price']) }}"
                                            oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                            name="primary_retail_price" id="primary_retail_price" class="form-control"
                                            placeholder="ادخل السعر  ">
                                        @error('primary_retail_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- first row class end --}}
                            </div>

                            <div class="row">

                                <div class=" col-3 ">
                                    <label> العدد المتاح بالمخزن </label>
                                    <select name='item_stock_type' id='item_stock_type' class="form-control">
                                        <option @selected(old('item_stock_type', $itemsData['item_stock_type']) == 1) value="1"> العدد مفتوح </option>
                                        <option @selected(old('item_stock_type', $itemsData['item_stock_type']) == 2) value="2"> عدد محدود </option>
                                    </select>
                                    @error('item_stock_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div id="inStockInput" class="col-4"
                                    @if ($itemsData['item_stock_type'] == 1) style="display: none" @endif>
                                    <label> ادخل الكمية </label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                        value="{{ old('stock_quantity', $itemsData['stock_quantity']) }}"
                                        placeholder="ادخل الكمية المتاحة بالمخزن"
                                        oninput="this.value=this.value.replace(/[^0-9.]/g,'');">
                                </div>
                                {{-- first second class end --}}
                            </div>
                            {{-- first card end --}}
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


    <script>
        //  when you use validation and go back you need to restore "#primary_unit_id" and "#retail_unit_id" and use thire values without
        // any addtional actions from the user
        var unit2 = $("#primary_unit_id").val();
        if (unit2 != "") {
            var name = $("#primary_unit_id option:selected").text();
            $(".parentUnitName").text(name);
        }
        var unit3 = $("#retail_unit_id").val();
        if (unit3 != "") {
            var name = $("#retail_unit_id option:selected").text();
            $(".childUnitName").text(name);
        }
        // check if the barcode form is empty
        $(document).on("click", "#edit_button", function(e) {
            if ($("#barcode").val() == "") {
                alert('ادخل الباركود');
                return false;
            }
        });
    </script>

@endsection
