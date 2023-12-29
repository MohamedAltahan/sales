<div id="ajax_search_div">
    @if (@count($data))
        @php
            $i = 1;
        @endphp
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
                <th>مسلسل </th>
                <th>كود الفاتورة </th>
                <th>المورد </th>
                <th> نوع الفاتورة</th>
                <th> حالة الفاتورة </th>
                <th>تاريخ الفاتورة</th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($data as $info)
                    <tr>

                        <td>{{ $i }}</td>
                        <td>{{ $info->auto_serial }}</td>
                        <td>{{ $info->supplier_name }}</td>
                        <td>
                            @if ($info->payment_type == 1)
                                كاش
                            @else
                                أجل
                            @endif
                        </td>
                        <td>
                            @if ($info->is_approved == 1)
                                تم الاعتماد
                            @else
                                لم يتم الاعتماد
                            @endif
                        </td>

                        <td>{{ $info->date }}</td>


                        <td>
                            <a href="{{ route('admin.supplier_orders.edit', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                            <a href="{{ route('admin.supplier_orders.delete', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-danger are_you_sure">حذف</a>
                            <a href="{{ route('admin.supplier_orders.delete', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-success ">اعتماد</a>
                            <a href="{{ route('admin.supplier_orders.details', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-info ">الاصناف</a>
                        </td>

                    </tr>

                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <br>

        <div class="col-md-12 d-flex justify-content-center" id="ajax_pagination_in_search">
            {{ $data->links() }}
        </div>
    @else
        <div class="alert alert-danger">
            لا يوجد بيانات
        </div>
    @endif
</div>
