@extends('layouts.admin')
@section('title', ' المشتريات')
@section('contentheader', ' حركات مخزنية ')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier_orders.index') }}">
        فواتير المشتريات </a>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
{{-- =======================================section content=================================================== --}}
@section('content')
    {{-- row class is mean a container in bootstrap --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تفاصيل فاتورة المشتريات </h3>
                </div>
                <!-- /.card-body -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}

                    <div id="ajax_reload_bill_div">
                        @if (!empty($data))
                            <table id="example2" class="table table-bordered table-hover">

                                <tr>
                                    <td class="width30">تاريخ الفاتورة </td>
                                    <td>{{ $data['order_date'] }}</td>
                                </tr>

                                <tr>
                                    <td class="width30">كود الفاتورة </td>
                                    <td>{{ $data['auto_serial'] }}</td>
                                </tr>


                                <tr>
                                    <td class="width30">اسم المورد </td>
                                    <td>{{ $data['supplier_name'] }}</td>
                                </tr>


                                <tr>
                                    <td class="width30">اجمالي الاصناف </td>
                                    <td>{{ $data['item_total_price'] }}</td>
                                </tr>

                                <tr>
                                    <td class="width30">تاريخ الاضافة </td>
                                    <td>

                                        {{ $data['created_at'] }}
                                        بواسطة
                                        {{ $data['added_by_admin'] }}

                                    </td>
                                </tr>
                                </tr>
                                <td class="width30">تاريخ اخر تحديث </td>
                                <td>
                                    @if ($data->updated_by > 0 and $data->updated_by != null)
                                        {{ $data['updated_at'] }}
                                        بواسطة
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        لا يوجد تحديث
                                    @endif
                                </td>
                                </tr>
                            </table>
                        @else
                            لا يوجد تحديث
                        @endif
                        {{-- end ajax parent bill --}}
                    </div>

                    <br>
                    @if ($data['is_approved'] == 0)
                        <div class="d-flex justify-content-center">
                            {{-- <div class="row"> --}}
                            <div>
                                <a href="{{ route('admin.supplier_orders.edit', $data->id) }}"
                                    class="btn btn btn-info">تعديل
                                    الفاتورة</a>
                            </div>

                            <button type="button" id="addToBillBtn" class="btn btn-primary mr-2" data-toggle="modal"
                                data-target="#add_item_modal">
                                اضافه صنف للفاتورة
                            </button>

                            <a href="{{ route('admin.supplier_orders.do_approve', $data['auto_serial']) }}" id="do_approve"
                                class="btn btn-danger">اعتماد الفاتورة </a>
                            {{-- </div> --}}
                        </div>
                    @endif
                    <br>

                    {{-- --------------------------------------show details ---------------------------------------- --}}

                    <div class="text-center ">
                        <p>الاصناف المضافة للفاتورة </p>
                        @if (count($details))
                            @if ($data['is_approved'] == 0)
                                <span style="color: red">(الفاتورة لم تعتمد ويمكن التعديل عليها)</span>
                            @else
                                <span style="color: red"> (تم اعتماد الفاتورة ولا يمكن التعديل عليها)</span>
                            @endif
                        @endif
                    </div><br>
                    <div id="ajax_details_div">
                        @if (count($details))
                            @php
                                // serial number
                                $i = 1;
                            @endphp
                            <table class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>الصنف </th>
                                    <th> الوحدة </th>
                                    <th> الكمية </th>
                                    <th> سعر الوحدة </th>
                                    <th> الاجمالي </th>
                                    <th></th>
                                </thead>

                                <tbody>

                                    @foreach ($details as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->unit_name }}</td>
                                            <td>{{ $info->received_quantity * 1 }}</td>
                                            <td>{{ $info->unit_price }}</td>
                                            <td>{{ $info->unit_total_price }}</td>
                                            <td>
                                                @if ($data['is_approved'] == 0)
                                                    <button data-id='{{ $info->id }}'
                                                        class="btn btn-sm btn-primary ajax_edit_item">تعديل</button>
                                                    <a {{-- send item 'id' and parent 'id'  --}}
                                                        href="{{ route('admin.supplier_orders.delete_item_details', [$info->id, $data->id]) }}"
                                                        class="btn btn-sm btn-danger are_you_sure">حذف</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                لا يوجد بيانات
                            </div>
                        @endif
                    </div>
                    <br>
                    {{-- --------------------------------------end show details ---------------------------------------- --}}

                    {{-- end card body class --}}
                </div>
                {{-- end card class --}}
            </div>

            {{-- end class="col-12" --}}
        </div>
        {{-- end class 'row' --}}
    </div>
    {{-- end section content --}}

    {{-- you have to use 'csrf_token' because you use 'post' method in ajax search --}}
    <input type="hidden" id="token_search" value="{{ csrf_token() }}">

    {{-- use auto_serial to search and get the data of this supplier --}}
    <input type="hidden" id="auto_serial" value="{{ $data['auto_serial'] }}">

    <input type="hidden" id="ajax_get_item_units_url" value="{{ route('admin.supplier_orders.ajax_get_item_units') }}">

    <input type="hidden" id="ajax_reload_edit_item_url"
        value="{{ route('admin.supplier_orders.ajax_reload_edit_item') }}">

    <input type="hidden" id="edit_item_details_url" value="{{ route('admin.supplier_orders.edit_item_details') }}">

    <input type="hidden" id="ajax_reload_parent_bill_url"
        value="{{ route('admin.supplier_orders.ajax_reload_parent_bill') }}">

    <input type="hidden" id="ajax_add_details_url" value="{{ route('admin.supplier_orders.ajax_add_details') }}">


    <input type="hidden" id="ajax_reload_items_details_url"
        value="{{ route('admin.supplier_orders.ajax_reload_items_details') }}">

    <input type="hidden" id="ajax_approve_invoice_url" value="{{ route('admin.supplier_orders.ajax_approve_invoice') }}">

    <input type="hidden" id="ajax_add_new_item_url" value="{{ route('admin.supplier_orders.ajax_add_new_item') }}">


    {{-- -------------------------------------modal 'add item' using ajax  ---------------------------------------- --}}

    <div class="modal" id="add_item_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-primary">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة اصناف للفاتورة</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body " id="add_item_modal_body" style="background-color:white; color: black !important">
                </div>


                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-danger " id="addToBill_button">اضافة الصنف للفاتورة</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- ----------------------------------end modal 'add item' using ajax  --------------------------------- --}}


    {{-- -------------------------------------modal 'edit item' using ajax  ---------------------------------------- --}}
    <div class="modal" id="edit_item_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-primary">
                <div class="modal-header">
                    <h4 class="modal-title">تحديث صنف بالفاتورة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body " id="edit_item_modal_body"
                    style="background-color:white; color: black !important">
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
                    {{-- if there is no date the variable $info will not be found so you have to check the data first --}}
                    @if (count($details))
                        <button type="button" class="btn btn-danger " data-id={{ $info->id }}
                            id="editItem_button">تعديل
                            الفاتورة</button>
                    @endif
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- ----------------------------------end modal 'edit item' using ajax  ---------------------------------------- --}}



@endsection


@section('script')

    <script src="{{ asset('assets/admin/js/supplierOrders.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>

@endsection
