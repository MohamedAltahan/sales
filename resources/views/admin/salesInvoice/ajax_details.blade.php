{{-- =======================================section content=================================================== --}}
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">

                    <h3 class="card-title card_title_center"> تفاصيل فاتورة المبيعات <span>

                        </span></h3>

                </div>
                <!-- /.card-body -->
                <div class="card-body">

                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead" style="color: black">
                            <th> رقم الفاتورة</th>
                            <th>اسم العميل</th>
                            <th>تاريخ الفاتورة </th>
                            <th> إجمالي الفاتورة </th>
                            <th> رصيد سابق </th>
                            <th> الإجمالي بالسابق </th>
                            <th> المدفوع </th>
                            <th> المتبقي </th>
                        </thead>
                        <tr>
                            <td>{{ $SalesInvoice->sales_invoice_id }}</td>
                            <td>{{ $customer_data->name }}</td>
                            <td>{{ $SalesInvoice->created_at }}</td>
                            <td>{{ $SalesInvoice->final_total_cost * 1 }}</td>
                            @if ($SalesInvoice->old_remain < 1)
                                <td>{{ $SalesInvoice->old_remain * -1 }} <span style="color: red">مدين</span> </td>
                            @elseif ($SalesInvoice->old_remain > 1)
                                <td>{{ $SalesInvoice->old_remain * 1 }} <span style="color: green">دائن</span> </td>
                            @endif
                            <td>{{ $SalesInvoice->invoice_total_price_with_old * 1 }}</td>
                            <td>{{ $SalesInvoice->what_paid * 1 }}</td>

                            @php
                                $what_remain = $SalesInvoice->invoice_total_price_with_old - $SalesInvoice->what_paid;
                            @endphp
                            @if ($what_remain > 1)
                                <td>{{ $what_remain * 1 }} <span style="color: red">مدين</span> </td>
                            @elseif ($what_remain == 0)
                                <td>{{ $what_remain * 1 }}
                                @elseif ($what_remain < 1)
                                <td>{{ $what_remain * 1 * -1 }}
                                    <span style="color: green">له</span>
                                </td>
                            @endif

                            {{-- <td>{{ $what_remain * 1 }}</td> --}}
                        </tr>
                    </table>


                    <table id="example2" class="table table-bordered table-hover mt-3">
                        <thead class="custom_thead" style="color: black">
                            <th> مسلسل</th>
                            <th>اسم الصنف</th>
                            <th>المقاس </th>
                            <th>العدد </th>
                            <th>سعر الوحدة </th>
                            <th> الاجمالي </th>

                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $info['item_name'] }}</td>
                                    <td>{{ $info['chassisWidthValue'] }}</td>
                                    <td>{{ $info['quantity'] * 1 }}</td>
                                    <td>{{ $info['unit_price'] * 1 }}</td>
                                    <td>{{ $info['total_unit_price'] * 1 }}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/admin/js/salesinvoice.js') }}"></script>
@endsection
