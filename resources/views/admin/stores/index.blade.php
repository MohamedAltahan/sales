@extends('layouts.admin')
@section('title', 'الضبط العام')
@section('contentheader', ' المخازن ')
@section('contentheaderlink')
    <a href="{{ route('admin.stores.index') }}">المخازن  </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات المخازن</h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasuries.ajax_search') }}">

                    <a href="{{ route('admin.stores.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    {{-- isset check if the variable isn't null --}}
                    <div id="ajax_search_div">
                        @if (@isset($data) && !@empty($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>اسم المخزن</th>
                                    <th>الهاتف</th>
                                    <th>العنوان</th>
                                    <th>حالة التفعيل</th>
                                    <th>تاريخ الاضافة</th>
                                    <th>  تاريخ التحديث </th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>

                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->phone }}</td>
                                            <td>{{ $info->address }}</td>
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
                                                    @if($info->updated_by >0 and $info->updated_by!=null)
                                                        {{ $info['updated_at'] }}
                                                        بواسطة
                                                        {{ $info['updated_by_admin'] }}
                                                    @else
                                                    لا يوجد تحديث
                                                    @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.stores.edit', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.stores.delete', $info->id) }}"
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
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
@endsection
