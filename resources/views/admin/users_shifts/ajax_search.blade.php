@if (count($data) > 0)

    @php
        $i = 1;
    @endphp

    <table id="example2" class="table table-bordered table-hover">
        <thead class="custom_thead">
            <th>مسلسل </th>
            <th>اسم الوحدة</th>
            <th>نوع الوحدة</th>
            <th>حالة التفعيل</th>
            <th>تاريخ الاضافة</th>
            <th> تاريخ التحديث </th>
            <th></th>
        </thead>

        <tbody>
            @foreach ($data as $info)
                <tr>

                    <td>{{ $i }}</td>
                    <td>{{ $info->name }}</td>
                    <td>
                        @if ($info->is_master == 1)
                            وحدة اساسية
                        @else
                            وحدة تجزيئة
                        @endif
                    </td>
                    <td>
                        @if ($info->active == 1)
                            مفعل
                        @else
                            معطل
                        @endif
                    </td>

                    <td>
                        {{ $info['created_at'] }}
                        بواسطة
                        {{ $info['added_by_admin'] }}
                    </td>

                    <td>
                        @if ($info->updated_by > 0 and $info->updated_by != null)
                            {{ $info['updated_at'] }}
                            بواسطة
                            {{ $info['updated_by_admin'] }}
                        @else
                            لا يوجد تحديث
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.units.edit', $info->id) }}"
                            class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                        <a href="{{ route('admin.units.delete', $info->id) }}"
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

    <div class="col-md-12 d-flex justify-content-center" id="ajax_pagination_in_search">
        {{ $data->links() }}
    </div>
@else
    <div class=" alert alert-danger">
        لا يوجد بيانات
    </div>
@endif
