@extends('layouts.admin')
@section('title', 'الضبط العام')
@section('contentheader', ' الخزن')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">الخزن </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الخزن</h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.treasuries.ajax_search') }}">

                    <a href="{{ route('admin.treasuries.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-4">
                        <input type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control">
                        <br>
                    </div>
                    {{-- isset check if the variable isn't null --}}

                    <div id="ajax_search_div">
                        @if (@isset($data) && !@empty($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>اسم الخزنه</th>
                                    <th>نوع الخزنة </th>
                                    <th>اخر ايصال تم صرفه</th>
                                    <th>اخر ايصال تم تحصيله</th>
                                    <th>حالة التفعيل</th>
                                    <th></th>

                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>
                                                @if ($info->is_master == 1)
                                                    رئيسية
                                                @else
                                                    فرعية
                                                @endif
                                            </td>
                                            <td>{{ $info->last_bill_exchange }}</td>
                                            <td>{{ $info->last_bill_collect }}</td>
                                            <td>
                                                @if ($info->active == 1)
                                                    مفعل
                                                @else
                                                    معطل
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.treasuries.edit', $info->id) }}"
                                                    class="btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.treasuries.details', $info->id) }}"
                                                    class="btn btn-sm btn-info">المزيد</a>
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
