@extends('layouts.admin')
@section('title', ' المبيعات')
@section('contentheader', ' فاتورة مبيعات ')
@section('contentheaderlink')
    <a href="{{ route('admin.salesInvoice.index') }}">
        فواتير المبيعات </a>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> فواتير المبيعات للعملاء </h3>


                    @if ($is_approved == 1)
                        <button class="btn btn-success" data-target="#addNewInvoiceModal" data-toggle='modal'>اضافة فاتورة
                            جديدة</button>
                    @else
                        <div class="col-12 btn btn-danger"> اخر فاتورة غير مكتملة يجب حذفها لاضافة فاتورة جديدة
                        </div>
                    @endif

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
                                    @foreach ($data as $info)
                                        <tr>

                                            <td>{{ $info->sales_invoice_id }}</td>
                                            <td>{{ $info->customer_name }}</td>
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

                                                {{-- <button id="printTarget" class="btn btn-sm btn-warning"> طباعة
                                                    الفاتورة</button> --}}

                                                <a href="{{ route('admin.salesInvoice.details', [$info->sales_invoice_id, $info->customer_id]) }}"
                                                    class=" mt-1 btn btn-sm btn-info ">طباعة </a>

                                                <a href="{{ route('admin.salesInvoice.details', [$info->sales_invoice_id, $info->customer_id]) }}"
                                                    class=" mt-1 btn btn-sm btn-warning ">الاصناف بالفاتورة</a>

                                                <a href="{{ route('admin.salesInvoice.delete', $info->sales_invoice_id) }}"
                                                    class=" ml-3 mt-1 btn btn-sm btn-danger are_you_sure">حذف</a>

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

    {{-- -------------------------------------modal 'edit item' using ajax  ---------------------------------------- --}}
    <div class="modal" id="addNewInvoiceModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-primary">
                <div class="modal-header">
                    <h4 class="modal-title"> اضافة فاتورة مبيعات جديدة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body " id="addNewInvoiceModalBody"
                    style="background-color:white; color: black !important">

                    {{-- you have to use 'csrf_token' because you use 'post' method in ajax search --}}
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">

                    <input type="hidden" id="ajax_add_new_item_url"
                        value="{{ route('admin.salesInvoice.ajax_add_new_item') }}">

                    <input type="hidden" id="ajax_totalInvoice_url"
                        value="{{ route('admin.salesInvoice.ajax_totalInvoice') }}">

                    <input type="hidden" id="ajax_delete_item_url"
                        value="{{ route('admin.salesInvoice.ajax_delete_item') }}">


                    <form action="{{ route('admin.salesInvoice.get_form_values') }}" method="post" id="valuesForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>تاريخ الفاتورة</label>
                                    <input type="date" name="invoiceDate" id="invoiceDate" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>


                            <div class=" col-4 ">
                                <label> اختار اسم العميل او <a href="http://localhost/sales/admin/customers/create"><span>
                                            (اضافة
                                            عميل جديد)</span></a></label>

                                <select name='customer_id' id="customer_id" class="form-control select2">
                                    <option value="">اختار اسم العميل</option>
                                    {{-- isset check if the variable isn't null --}}
                                    @if (@isset($customers) && !@empty($customers))
                                        @foreach ($customers as $info)
                                            {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                            <option data-balance="{{ $info->current_balance }}"
                                                value="{{ $info->id }}">
                                                {{ $info->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="">رصيد سابق
                                    <span id='debit' style="color: red;display:none">مدين</span>
                                    <span id='credit' style="color: rgb(0, 164, 0);display:none">له</span>
                                </label>

                                <input readonly class="form-control" type="text" value="" id='oldRemain'
                                    name="oldRemain">
                            </div>

                            <div class="col-md-2">
                                <label for="">كود الفاتورة </label>
                                <input readonly class="form-control" type="text" value={{ $sales_invoice_id }}
                                    id='sales_invoice_id' name="sales_invoice_id">
                            </div>


                            {{-- end row class --}}
                        </div>

                        {{-- ---------------------------------------- horizontal line --------------------------- --}}
                        <hr style="border:1px solid #3c8dbc;">
                        {{-- ----------------------------------------end horizontal line ----------------------- --}}

                        <div class="row">

                            <div class=" col-md-3 ">
                                <label> اختار الصنف او <a href="http://localhost/sales/admin/items/index"><span> (اضافة صنف
                                            جديد)</span></a></label>
                                <select name='item_code' id="item_code" class="form-control select2">
                                    <option value=""> اختر الصنف</option>
                                    {{-- isset check if the variable isn't null --}}
                                    @if (@isset($items) && !@empty($items))
                                        @foreach ($items as $info)
                                            {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                            <option data-type="{{ $info->item_type }}"
                                                data-price="{{ $info->primary_retail_price }}"
                                                data-quantity="{{ $info->stock_quantity }}"
                                                data-unit="{{ $info->primary_unit_id }}" value="{{ $info->item_code }}">
                                                {{ $info->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-2" id="chassisWidth" style="display: none">
                                <label for="">عرض الشاسية بالـ<span style="color: red">CM</span></label>
                                <input id="chassisWidthValue" name="chassisWidthValue"
                                    oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control"
                                    type="text" value="100" placeholder="عرض الشاسيه">
                            </div>

                            <div class="btn btn-success" id="addToQuantity">
                                <h5 class="pt-3">+</h5>
                            </div>

                            <div class="col-md-1">
                                <label for="">العدد</label>
                                <input oninput="this.value=this.value.replace(/[^0-9.]/g,'');" class="form-control"
                                    type="text" value="1" id='quantity' name="quantity">
                            </div>

                            <div class="btn btn-danger" id="subFromQuantity">
                                <h5 class="pt-3 pr-1"> - </h5>
                            </div>

                            <div class="col-md-2">
                                <label for="">السعر الكلي </label>
                                <input readonly oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                    class="form-control" type="text" value="" id='totalOneItemPrice'
                                    name="totalOneItemPrice">
                            </div>

                            <div class="col-md-1">
                                <label for=""> المخزون </label>
                                <input readonly class="form-control" type="text" value="" id='stock_quantity'
                                    name="stock_quantity">
                            </div>
                            {{-- <button id="addToInvoice">اضافة للفاتورة </button> --}}
                            <a class="btn btn-warning pt-4 " style="color:white" id="addToInvoice">اضافة للفاتورة </a>
                            {{-- <a class="btn btn-warning pt-4 " style="color:white" id="addToInvoicee">اضافة للفاتورة </a> --}}
                            {{-- end secondrow --}}
                        </div>

                        {{-- ---------------------------------------- horizontal line --------------------------- --}}
                        <hr style="border:1px solid #3c8dbc;">
                        {{-- ----------------------------------------end horizontal line ----------------------- --}}
                        <div class="row mr-3">

                            <label class="mr-1 pt-2"> إجمالي الفاتورة الحالية </label>
                            <div class="col-md-2">
                                <div id="ajax_totalInvoice">
                                    <input readonly class="form-control" type="text" value="0" id='totalInvoice'
                                        name="totalInvoice">
                                </div>

                            </div>

                            <label class="mr-1 pt-2"> <span style="color:red">المدفوع</span> </label>
                            <div class="col-md-2">
                                <input class="form-control" type="text" value="0" id='what_paid'
                                    name="what_paid">
                            </div>

                            <label class="mr-1 pt-2"> <span style="color:red"> ماتم دفعه من القديم</span> </label>
                            <div class="col-md-2">
                                <input readonly class="form-control" type="text" value="0" id='what_old_paid'
                                    name="what_old_paid">
                            </div>

                        </div>
                        <div class="row  mt-3 mr-3 ">
                            <label class="mr-1 pt-2"> الاجمالي بالرصيد السابق </label>
                            <div class="col-md-4">
                                <input readonly class="form-control" type="text" value="0"
                                    id="invoice_total_price_with_old" name="invoice_total_price_with_old">
                            </div>

                            <label class="mr-1 pt-2"> المتبقي </label>
                            <div class="col-md-4">
                                <input readonly class="form-control" type="text" value="0" id='what_remain'
                                    name="what_remain">
                            </div>
                            <label style="display: none;color:rgb(85, 142, 0) "class=" pt-2 debit"> لـه </label>
                        </div>
                    </form>
                    {{-- end second class row --}}

                    {{-- ---------------------------------------- horizontal line --------------------------- --}}
                    <hr style="border:1px solid #3c8dbc;">
                    {{-- ----------------------------------------end horizontal line ----------------------- --}}

                    <table id="example2" class="table table-bordered table-hover table-sm">

                        <thead class="custom_thead">
                            <th>اسم الصنف</th>
                            <th>المقاس </th>
                            <th>العدد </th>
                            <th>سعر الوحدة </th>
                            <th> الاجمالي </th>
                            <th> </th>
                        </thead>

                        <tbody id="ajax_add_new_item">
                        </tbody>

                    </table>

                    <div class="text-center">
                        <input type="submit" form="valuesForm" class="btn btn-danger" value="اعتماد">
                    </div>


                    {{-- end modal body --}}
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
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>

@endsection
