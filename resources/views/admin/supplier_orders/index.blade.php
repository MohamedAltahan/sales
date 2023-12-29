@extends('layouts.admin')
@section('title', ' المشتريات')
@section('contentheader', ' حركات مخزنية ')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier_orders.index') }}">فواتير المشتريات </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> فواتير المشتريات </h3>

                    {{-- you have to use 'csrf_token' because you use 'post' method in ajax search --}}
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.supplier_orders.ajax_search') }}">

                    <a href="{{ route('admin.supplier_orders.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- ajax search --}}
                    <div class="row">

                    </div>
                    {{-- isset check if the variable isn't null --}}
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
                                                @if ($info->is_approved == 1)
                                                    <span style="color: green"> تم الاعتماد</span>
                                                @else
                                                    <span style="color: red"> لم يتم الاعتماد</span>
                                                @endif
                                            </td>

                                            <td>{{ $info->order_date }}</td>

                                            <td>
                                                @if ($info->is_approved == 0)
                                                    <a href="{{ route('admin.supplier_orders.edit', $info->id) }}"
                                                        class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                                                    <a href="{{ route('admin.supplier_orders.do_approve', $info->auto_serial) }}"
                                                        class=" mt-1 btn btn-sm btn-success ">اعتماد</a>
                                                @endif
                                                <a href="{{ route('admin.supplier_orders.details', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-info ">الاصناف بالفاتورة</a>
                                                <a href="{{ route('admin.supplier_orders.delete_supplier_order', $info->id) }}"
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
