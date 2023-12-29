{{-- this page receives there parameters the first is collection of objects '$data' which contains all transaction's data,
the second is an object '$current_shift_state' which contains info about the current user's shift 
third is $accounts which contains accounts name and account_number --}}
@extends('layouts.admin')
@section('title', 'شاشة تحصيل النقدية')
@section('contentheader', ' الحسابات')
@section('contentheaderlink')
    <a href="{{ route('admin.collect_transactions.index') }}">بيانات حركة تحصيل النقدية بالنظام </a>
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
                    <h3 class="card-title card_title_center">بيانات الخزن</h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                </div>
                <!-- /.card-header -->
                <div class="card-body">


                    @if (!@empty($current_shift_state))
                        <form action="{{ route('admin.collect_transactions.store') }}" method="post">
                            @csrf
                            {{-- =======================================start of the first card========================================== --}}
                            <div class="card ">
                                <div class="row ">

                                    <div class=" col-4 ">
                                        <div class="form-group">
                                            <label>تاريخ التحصيل </label>
                                            <input value="{{ old('transaction_date', date('Y-m-d')) }}" type="date"
                                                name="transaction_date" id="transaction_date" class="form-control">
                                            @error('transaction_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" col-4 ">
                                        <label>الحسابات المالية </label>
                                        <select name='account_number' id='account_number' class="form-control select2">
                                            <option value="">اختار الحساب المالي المحصل منة</option>
                                            {{-- isset check if the variable isn't null --}}
                                            @if (@isset($accounts) && !@empty($accounts))
                                                @foreach ($accounts as $info)
                                                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                    <option @selected(old('account_number') == $info->account_number) value="{{ $info->account_number }}"
                                                        data-type={{ $info->account_type_id }}>
                                                        {{ $info->name }} ({{ $info->account_type_name }})</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('account_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class=" col-4 ">
                                        <label> نوع المعاملة</label>
                                        <select name='transaction_type' id='transaction_type' class="form-control ">
                                            <option value="">اختار نوع المعاملة</option>
                                            {{-- isset check if the variable isn't null --}}
                                            @if (@isset($transaction_type) && !@empty($transaction_type))
                                                @foreach ($transaction_type as $info)
                                                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                    <option @selected(old('transaction_type') == $info->transaction_typesID)
                                                        value="{{ $info->transaction_typesID }}">
                                                        {{ $info->transaction_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('transaction_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class=" col-4" id="account_status"></div>

                                    <div class=" col-4 ">
                                        <label>بيانات الخزن </label>
                                        <select name='treasury_id' class="form-control">
                                            <option value="{{ $current_shift_state->treasury_id }}">
                                                {{ $current_shift_state->treasury_name }}
                                            </option>
                                        </select>
                                        @error('treasury_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class=" col-4 ">
                                        <div class="form-group">
                                            <label> الرصيد المتاح بالخزنة</label>
                                            <input value="{{ $current_shift_state['treasury_balance'] }}" readonly
                                                name="treasury_balance" id="treasury_balance" class="form-control">
                                            @error('treasury_balance')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" col-4 ">
                                        <div class="form-group">
                                            <label>قيمة المبلغ المحصل</label>
                                            <input value="{{ old('transaction_money_value') }}"
                                                oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                                name="transaction_money_value" id="transaction_money_value"
                                                class="form-control" placeholder="ادخل قيمة المبلغ المحصل  ">
                                            @error('transaction_money_value')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class=" col-8 ">
                                        <div class="form-group">
                                            <label> ملاحظات </label>
                                            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
                                            @error('note')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- first row class end --}}
                                </div>
                                {{-- first card end --}}
                            </div>
                            {{-- ============================================end of the first card============================================ --}}

                            {{-- big 'cardbody' end --}}
                </div>

                <div class="text-center">
                    <button class="btn btn-lg btn-success mb-1"> تحصيل </button>
                </div>

                </form>
            @else
                <div class="alert alert-warning">
                    لا يوجد شفت مفتوح الان لكي تتمكن من التحصيل
                </div>
                @endif


                @if (count($data))
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>كود تلقائي </th>
                            <th>رقم الايصال </th>
                            <th> الخزنة </th>
                            <th> المبلغ</th>
                            <th> نوع المعاملة</th>
                            <th>البيان</th>
                            <th>المستخدم </th>
                            <th>تاريخ الاضافة</th>
                            <th> تاريخ التحديث </th>
                            <th></th>
                        </thead>

                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->auto_serial }}</td>
                                    <td>{{ $info->bill_number }}</td>
                                    <td>{{ $info->treasury_name }}</td>
                                    <td>{{ $info->transaction_money_value * 1 }}</td>
                                    <td>{{ $info->transaction_type_name }}</td>
                                    <td>{{ $info->note }}</td>
                                    <td>{{ $info->user_name }}</td>
                                    <td>
                                        {{ $info['created_at'] }}
                                        بواسطة
                                        {{ $info['user_name'] }}
                                    </td>
                                    <td>
                                        @if ($info->updated_by > 0 and $info->updated_by != null)
                                            {{ $info['updated_at'] }}
                                            بواسطة
                                            {{ $info['updated_by'] }}
                                        @else
                                            لا يوجد تحديث
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.treasuries.edit', $info->treasuries_transactionsID) }}"
                                            class="btn btn-sm btn-primary">طباعة</a>
                                        <a href="{{ route('admin.treasuries.edit', $info->treasuries_transactionsID) }}"
                                            class="btn btn-sm btn-info">تحصيل</a>
                                    </td>
                                    <br>
                                </tr>
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

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/collect_transaction.js') }}"></script>
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>


@endsection
