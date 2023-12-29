@extends('layouts.admin')
@section('title', ' ضبط المخازن')
@section('contentheader', ' الاصناف ')
@section('contentheaderlink')
    <a href="{{ route('admin.items.index') }}">الاصناف </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات الاصناف</h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.items.ajax_search') }}">

                    <a href="{{ route('admin.items.create') }}" class="btn btn-sm btn-success">اضافه منتج جديد </a>
                    <a href="{{ route('admin.items.create_size') }}" class="btn btn-sm btn-success">اضافه مقاس جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    {{-- -------------------------------ajax search section---------------------------------------------- --}}
                    <div class="row">
                        {{-- -----------------search by name or barcode or item-code--------------- --}}
                        <div class="col-md-4">
                            <label style=" color : red"> بحث بــ </label>

                            <input type="radio" name="radio_search" id="radio_name" value="name" checked>
                            <label for="radio_name">بالاسم</label>
                            <input type="text" id="search_by_text" placeholder=" ادخل اسم الصنف" class="form-control">

                            <br>

                        </div>

                        {{-- end of the row div --}}
                    </div>
                    {{-- ---------------------- ajax_search_div div used when you use ajax search ---------------------- --}}
                    {{-- isset check if the variable isn't null --}}
                    <div id="ajax_search_div">
                        @if (@count($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>الاسم </th>
                                    <th>السعر </th>
                                    <th>الوحدة الاساسية</th>
                                    <th>المخزون المتاح </th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>

                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->primary_retail_price * 1 }}</td>
                                            <td>{{ $info->primary_unit_name }}</td>
                                            @if ($info->item_stock_type == 1)
                                                <td>غير محدد</td>
                                            @else
                                                <td>{{ $info->stock_quantity * 1 }}</td>
                                            @endif


                                            <td>
                                                @if ($info->item_type == 2)
                                                    <a href="{{ route('admin.items.edit_size', $info->id) }}"
                                                        class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                                                @else
                                                    <a href="{{ route('admin.items.edit', $info->id) }}"
                                                        class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                                                @endif

                                                <a href="{{ route('admin.items.delete', $info->id) }}"
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
                        {{-- end ajax_search_div  --}}
                    </div>
                    {{-- end card-body --}}
                </div>
                {{-- end card --}}
            </div>

        </div>
        {{-- end div 'row' class --}}
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/inv_items.js') }}"></script>
@endsection
