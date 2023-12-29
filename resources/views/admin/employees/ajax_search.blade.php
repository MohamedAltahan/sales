    {{-- ---------------------- ajax_search_div div used when you use ajax search ---------------------- --}}
    {{-- isset check if the variable isn't null --}}

    @if (@count($data))
        @php
            $i = 1;
        @endphp
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
                <th>الاسم </th>
                <th>كود العميل </th>
                <th> الرصيد </th>


                <th></th>
            </thead>

            <tbody>
                @foreach ($data as $info)
                    <tr>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->customer_code }}</td>

                        @if ($info->current_balance < 0)
                            <td>{{ $info->current_balance * -1 }}
                                <span style="color: red">مدين</span>
                            </td>
                        @elseif ($info->current_balance > 0)
                            <td>{{ $info->current_balance }}
                                <span style="color: rgb(19, 179, 1)">له</span>
                            </td>
                        @else
                            <td>{{ $info->current_balance }}</td>
                        @endif

                        <td>
                            <a href="{{ route('admin.customers.edit', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                            <a href="{{ route('admin.customers.delete', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-danger are_you_sure">حذف</a>
                            <a href="{{ route('admin.customers.delete', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-info ">جميع الفواتير</a>

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
