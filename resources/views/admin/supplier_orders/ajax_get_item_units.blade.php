    <label> بيانات وحدات الصنف</label>
    <select name='unit_id_add ' id='unit_id_add' class="form-control select2">
        <option value=""> اختر الوحدة</option>
        {{-- isset check if the variable isn't null --}}
        @if (@isset($item_data) && !@empty($item_data))
            @if ($item_data['has_retailunit'] == 1)
                <option data-parent_unit='1' value="{{ $item_data['primary_unit_id'] }}">
                    {{ $item_data['primary_unit_name'] }}
                    (واحدة اب)
                </option>
                <option data-parent_unit='0' value="{{ $item_data['retail_unit_id'] }}">
                    {{ $item_data['retail_unit_name'] }}
                    (واحدة تجزيئة)
                </option>
            @else
                <option data-parent_unit='1' value="{{ $item_data['primary_unit_id'] }}">
                    {{ $item_data['primary_unit_name'] }}
                    (واحدة اب)
                </option>
            @endif
        @endif
    </select>
