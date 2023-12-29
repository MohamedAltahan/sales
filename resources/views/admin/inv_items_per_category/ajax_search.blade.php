    {{-- ---------------------- ajax_search_div div used when you use ajax search ---------------------- --}}
    {{-- isset check if the variable isn't null --}}

    @if (@count($data))
        @php
            $i = 1;
        @endphp
        <table id="example2" class="table table-bordered table-hover">
            <thead class="custom_thead">
                <th>مسلسل </th>
                <th>الاسم </th>
                <th>الوحدة الاساسية</th>
                <th></th>
            </thead>

            <tbody>
                @foreach ($data as $info)
                    <tr>

                        <td>{{ $i }}</td>
                        <td>{{ $info->name }}</td>
                        <td>{{ $info->primary_unit_name }}</td>

                        <td>
                            <a href="{{ route('admin.items.edit', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                            <a href="{{ route('admin.items.delete', $info->id) }}"
                                class=" mt-1 btn btn-sm btn-danger are_you_sure">حذف</a>
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
            لا يوجد بيانات
        </div>
    @endif
