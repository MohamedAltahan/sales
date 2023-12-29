@extends('layouts.admin')
@section('title', ' الوحدات')
@section('contentheader', ' الوحدات ')
@section('contentheaderlink')
    <a href="{{ route('admin.units.index') }}">الوحدات </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات وحدات قياس الاصناف</h3>

                    {{-- you have to use 'csrf_token' because you use 'post' method in ajax search --}}
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.units.ajax_search') }}">

                    <a href="{{ route('admin.units.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">


                    {{-- isset check if the variable isn't null --}}
                    <div id="ajax_search_div">
                        @if (@count($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>اسم الوحدة</th>
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
    <script src="{{ asset('assets/admin/js/inv_units.js') }}"></script>
@endsection
