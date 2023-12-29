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
            <td class="width30"> رقم الفاتورة الخاص بشركة المورد</td>
            <td>{{ $data['doc_no'] }}</td>
        </tr>

        <tr>
            <td class="width30">اسم المورد </td>
            <td>{{ $data['supplier_name'] }}</td>
        </tr>

        <tr>
            <td class="width30">نوع الفاتورة </td>
            <td>
                @if ($data['payment_type'] == 1)
                    كاش
                @else
                    اجل
                @endif
            </td>
        </tr>

        <tr>
            <td class="width30">اسم المخزن المستلم </td>
            <td>{{ $data['store_name'] }}</td>
        </tr>

        <tr>
            <td class="width30">اجمالي الفاتورة بدون ضريبة</td>
            <td>{{ $data['item_total_price'] * 1 }}</td>
        </tr>

        @if ($data['discount_type'] != null)
            <tr>
                <td class="width30"> الخصم على الفاتورة</td>
                <td>
                    @if ($data['discount_type'] == 1)
                        خصم نسبة %( {{ $data['discount_percent'] * 1 }} )وقيمتها
                        ( {{ $data['discount_value'] * 1 }} )
                    @else
                        خصم يدوى وقيمته
                        {{ $data['discount_value'] * 1 }}
                    @endif
                </td>
            </tr>
        @else
            <tr>
                <td class="width30"> الخصم على الفاتورة</td>
                <td>لا يوجد خصم</td>
            </tr>
        @endif


        <tr>
            <td class="width30"> نسبة القيمة المضافة </td>
            <td>
                @if ($data['tax_percent'] > 0)
                    نسبة {{ $data['tax_percent'] * 1 }} وقيمتها {{ $data['tax_value'] * 1 }}
                @else
                    لايوجد
                @endif
            </td>
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
