<div class="row">

    <div class=" col-md-4 ">
        <label> بيانات الصنف</label>
        <select name='item_code_add' id="item_code_add" class="form-control select2">
            <option value=""> اختر الصنف</option>
            {{-- isset check if the variable isn't null --}}
            @if (@isset($items) && !@empty($items))
                @foreach ($items as $info)
                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                    <option data-type="{{ $info->item_type }}" @selected($item_details['item_code'] == $info->item_code)
                        value="{{ $info->item_code }}">
                        {{ $info->name }}</option>
                @endforeach
            @endif
        </select>
        @error('item_code_add')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    {{-- this div is used as a container to show unit using ajax --}}
    <div class=" col-md-4 unit_div" id="unitDivAdd">
        <label> بيانات وحدات الصنف</label>
        <select name='unit_id_add ' id='unit_id_add' class="form-control select2">
            <option value=""> اختر الوحدة</option>
            @if (@isset($item_data) && !@empty($item_data))
                @if ($item_data['has_retailunit'] == 1)
                    <option @selected($item_data['primary_unit_id'] == $item_details['unit_id']) data-parent_unit='1'
                        value="{{ $item_details['primary_unit_id'] }}">
                        {{ $item_data['primary_unit_name'] }}
                        (واحدة اب)
                    </option>

                    <option @selected($item_data['retail_unit_id'] == $item_details['unit_id']) data-parent_unit='0'
                        value="{{ $item_data['retail_unit_id'] }}">
                        {{ $item_data['retail_unit_name'] }}
                        (واحدة تجزيئة)
                    </option>
                @else
                    <option selected data-parent_unit='1' value="{{ $item_data['primary_unit_id'] }}">
                        {{ $item_data['primary_unit_name'] }}
                        (واحدة اب)
                    </option>
                @endif
            @endif
        </select>
    </div>

    <div class=" col-md-4 unit_div">
        <div class="form-group">
            <label>الكمية المستلمة</label>
            <input value="{{ $item_details['received_quantity'] * 1 }}"
                oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="quantity_add" id="quantity_add"
                class="form-control">
        </div>
    </div>

    <div class=" col-md-4 unit_div">
        <div class="form-group">
            <label>سعر الوحدة </label>
            <input value="{{ $item_details['unit_price'] * 1 }}" oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                id="price_add" class="form-control">
        </div>
    </div>

    <div class=" col-md-4 date_div" @if ($item_details['item_type'] != 2) style="display:none" @endif>
        <div class="form-group">
            <label> تاريخ الانتاج </label>
            <input value="{{ $item_details['production_date'] }}" type="date" id="production_date"
                class="form-control">
        </div>
    </div>

    <div class=" col-md-4 date_div" @if ($item_details['item_type'] != 2) style="display:none" @endif>
        <div class="form-group">
            <label> تاريخ الانتهاء </label>
            <input value="{{ $item_details['expire_date'] }}" type="date" id="expire_date" class="form-control">
        </div>
    </div>



    <div class=" col-md-4 unit_div">
        <div class="form-group">
            <label style="color:red"> الاجمالي </label>
            <input readonly value="{{ $item_details['unit_total_price'] * 1 }}"
                oninput="this.value=this.value.replace(/[^0-9]/g,'');" id="total_add" class="form-control">
        </div>
    </div>

</div>
