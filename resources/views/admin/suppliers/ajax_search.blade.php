<div id="ajax_search_div">
    @if (@count($data))
        @php
            $i = 1;
        @endphp
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
                <th>مسلسل </th>
                <th>الاسم </th>
                <th>نوع المورد </th>
                <th>كود المورد </th>
                <th> الرصيد </th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($data as $info)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->supplier_type_name }}</td>
                        <td>{{ $info->supplier_code }}</td>
                        <td>{{ $info->current_balance }}</td>

                        <td>
                            <a href="{{ route('admin.suppliers.edit', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                            <a href="{{ route('admin.suppliers.delete', $info->id) }}"
                                class=" mt-1 ml-3 btn btn-sm btn-danger are_you_sure">حذف</a>

                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="d-flex justify-content-center"> {{ $data->links() }}</div>
    @else
        <div class="alert alert-danger">
            لا يوجد بيااانات
        </div>
    @endif
    {{-- end ajax_search_div  --}}
</div>
