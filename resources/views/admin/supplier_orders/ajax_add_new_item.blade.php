<div class="row">

    <div class=" col-md-4 ">
        <label> بيانات الصنف</label>
        <select name='item_code_add' id="item_code_add" class="form-control select2">
            <option value=""> اختر الصنف</option>
            {{-- isset check if the variable isn't null --}}
            @if (@isset($items) && !@empty($items))
                @foreach ($items as $info)
                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                    <option data-type="{{ $info->item_type }}" value="{{ $info->item_code }}">
                        {{ $info->name }}</option>
                @endforeach
            @endif
        </select>
        @error('item_code_add')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- this div is used as a container to show unit using ajax --}}
    <div class=" col-md-4 unit_div" style="display:none" id="unitDivAdd">
    </div>

    <div class=" col-md-4 unit_div" style="display:none">
        <div class="form-group">
            <label>الكمية المستلمة</label>
            <input value="" oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="quantity_add"
                id="quantity_add" class="form-control">
        </div>
    </div>

    <div class=" col-md-4 unit_div" style="display:none">
        <div class="form-group">
            <label>سعر الوحدة </label>
            <input value="" oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="price_add"
                class="form-control">
        </div>
    </div>



    <div class=" col-md-4 unit_div" style="display:none">
        <div class="form-group">
            <label style="color:red"> الاجمالي </label>
            <input readonly value="" oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="total_add"
                class="form-control">
        </div>
    </div>

</div>
