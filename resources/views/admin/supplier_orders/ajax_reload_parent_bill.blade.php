@if (!empty($data))
    <table id="example2" class="table table-bordered table-hover">

        <tr>
            <td class="width30">تاريخ الفاتورة </td>
            <td>{{ $data['order_date'] }}</td>
        </tr>

        <tr>
            <td class="width30">كود الفاتورة </td>
            <td>{{ $data['auto_serial'] }}</td>
        </tr>

        <tr>
            <td class="width30">اسم المورد </td>
            <td>{{ $data['supplier_name'] }}</td>
        </tr>



        <tr>
            <td class="width30">اجمالي الفاتورة </td>
            <td>{{ $data['item_total_price'] * 1 }}</td>
        </tr>



        <tr>
            <td class="width30">تاريخ الاضافة </td>
            <td>

                {{ $data['created_at'] }}
                بواسطة
                {{ $data['added_by_admin'] }}

            </td>
        </tr>
        </tr>
        <td class="width30">تاريخ اخر تحديث </td>
        <td>
            @if ($data->updated_by > 0 and $data->updated_by != null)
                {{ $data['updated_at'] }}
                بواسطة
                {{ $data['updated_by_admin'] }}
            @else
                لا يوجد تحديث
            @endif
        </td>
        </tr>
    </table>
@else
    لا يوجد تحديث
@endif
