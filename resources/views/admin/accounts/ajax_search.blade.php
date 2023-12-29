    {{-- ---------------------- ajax_search_div div used when you use ajax search ---------------------- --}}
    {{-- isset check if the variable isn't null --}}

    @if (@count($data))
        @php
            $i = 1;
        @endphp
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
                <th>الاسم </th>
                <th>رقم الحساب </th>
                <th>النوع</th>
                <th> هل اساسي</th>
                <th> الحساب الاساسي</th>
                <th> الرصيد </th>
                <th>حالة التفعيل</th>

                <th></th>
            </thead>

            <tbody>
                @foreach ($data as $info)
                    <tr>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->account_number }}</td>
                        <td>{{ $info->account_type_name }}</td>
                        <td>
                            @if ($info->is_primary == 1)
                                نعم
                            @else
                                لا
                            @endif
                        </td>
                        <td>{{ $info->primary_account_name }}</td>
                        <td></td>

                        <td>
                            @if ($info->active == 1)
                                مفعل
                            @else
                                معطل
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.accounts.edit', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                            <a href="{{ route('admin.accounts.delete', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-danger are_you_sure">حذف</a>
                            <a href="{{ route('admin.accounts.show', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-info">المزيد</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="d-flex justify-content-center" id="ajax_pagination_in_search"> {{ $data->links() }}</div>
    @else
        <div class="alert alert-danger">
            لا يوجد بيااانات
        </div>
    @endif
    {{-- end ajax_search_div  --}}
    </div>
