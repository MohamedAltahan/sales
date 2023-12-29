@extends('layouts.admin')
@section('title', 'فوواتير العميل')
@section('contentheader', ' فواتير العميل ')
@section('contentheaderlink')
    <a href="{{ route('admin.customers.index') }}">
        فواتير المبيعات </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> فواتير المبيعات للعملاء </h3>

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
                                    <th>رقم الفاتورة </th>
                                    <th>اسم العميل</th>
                                    <th>التاريخ </th>
                                    <th> الاجمالي </th>
                                    <th> المدفوع </th>
                                    <th> المتبقي </th>
                                    <th> هل معتمدة </th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->id }}</td>
                                            <td>{{ $customer_name }}</td>
                                            <td>{{ $info->created_at }}</td>
                                            <td>{{ $info->invoice_total_price_with_old * 1 }}</td>
                                            <td>{{ $info->what_paid * 1 }}</td>

                                            @if ($info->what_remain > 1)
                                                <td>{{ $info->what_remain * 1 }} <span style="color: red">مدين</span> </td>
                                            @elseif ($info->what_remain == 0)
                                                <td>{{ $info->what_remain * 1 }}
                                                @elseif ($info->what_remain < 1)
                                                <td>{{ $info->what_remain * -1 }} <span style="color: green">له</span>
                                                </td>
                                            @endif


                                            <td>

                                                @if ($info->is_approved == 1)
                                                    <span style="color: rgb(45, 190, 45)">معتمدة</span>
                                                @else
                                                    <span style="color:red">غير معتمدة</span>
                                                @endif

                                            </td>


                                            <td>
                                                {{-- @if ($info->is_approved == 0)
                                                    <a href="{{ route('admin.salesInvoice.do_approve', $info->sales_invoice_id) }}"
                                                        class=" mt-1 btn btn-sm btn-success " style="color:white">اعتماد
                                                        الفاتوره</a>
                                                @endif --}}


                                                <a href="{{ route('admin.salesInvoice.details', [$info->sales_invoice_id, $info->customer_id]) }}"
                                                    class=" mt-1 btn btn-sm btn-info ">الاصناف بالفاتورة</a>

                                                <a href="{{ route('admin.salesInvoice.delete', $info->sales_invoice_id) }}"
                                                    class=" mt-1 mr-1 ml-1 btn btn-sm btn-danger are_you_sure">حذف</a>
                                                {{-- <a href="{{ route('admin.salesInvoice.details', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-info ">طباعة</a> --}}
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



    <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
        {{-- if there is no date the variable $info will not be found so you have to check the data first --}}
        {{-- @if (count($details))
                        <button type="button" class="btn btn-danger " data-id={{ $info->id }}
                            id="editItem_button">تعديل
                            الفاتورة</button>
                    @endif --}}
    </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    {{-- ----------------------------------end modal 'edit item' using ajax  ---------------------------------------- --}}
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/salesinvoice.js') }}"></script>
@endsection
