@if (count($details))
    @php
        // serial number
        $i = 1;
    @endphp
    <table class="table table-bordered table-hover">
        <thead class="custom_thead">
            <th>مسلسل </th>
            <th>الصنف </th>
            <th> الوحدة </th>
            <th> الكمية </th>
            <th> سعر الوحدة </th>
            <th> الاجمالي </th>
            <th></th>
        </thead>

        <tbody>

            @foreach ($details as $info)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $info->name }}
                        @if ($info->item_type == 2)
                            <br>
                            تاريخ الانتاج <span style="color: red ">{{ $info->production_date }}</span>
                            <br>
                            تاريخ الانتهاء <span style="color: red ">{{ $info->expire_date }}</span>
                        @endif
                    </td>
                    <td>{{ $info->unit_name }}</td>
                    <td>{{ $info->received_quantity * 1 }}</td>
                    <td>{{ $info->unit_price }}</td>
                    <td>{{ $info->unit_total_price }}</td>
                    <td>
                        @if ($data['is_approved'] == 0)
                            <button data-id='{{ $info->id }}'
                                class="btn btn-sm btn-primary ajax_edit_item">تعديل</button>
                            <a
                                href="{{ route('admin.supplier_orders.delete_item_details', [$info->id, $data->id]) }}"class="btn btn-sm btn-danger are_you_sure">حذف</a>
                        @endif
                    </td>
                </tr>

                @php $i++; @endphp
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-danger">
        لا يوجد بيانات
    </div>
@endif
