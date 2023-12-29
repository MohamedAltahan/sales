{{-- this page receives there parameters the first is collection of objects '$data' which contains all transaction's data,
the second is an object '$current_shift_state' which contains info about the current user's shift 
third is $accounts which contains accounts name and account_number --}}
@extends('layouts.admin')
@section('title', 'شاشة صرف النقدية')
@section('contentheader', ' الحسابات')
@section('contentheaderlink')
    <a href="{{ route('admin.collect_transactions.index') }}">بيانات حركة صرف النقدية بالنظام </a>
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
                    <form action="{{ route('admin.exchange_transactions.store') }}" method="post">
                        @csrf
                        {{-- =======================================start of the first card========================================== --}}
                        <div class="card ">
                            <div class="row pl-2 pt-1">
                                <div class=" col-4 ">
                                    <div class="form-group">
                                        <label>تاريخ الصرف </label>
                                        <input value="{{ old('transaction_date', date('Y-m-d')) }}" type="date"
                                            name="transaction_date" id="transaction_date" class="form-control">
                                        @error('transaction_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-4 ">
                                    <label>حسابات الموظفين </label>
                                    <select name='account_number' id='account_number' class="form-control select2">
                                        <option value="">اختار الحساب المصروف له</option>
                                        {{-- isset check if the variable isn't null --}}
                                        @if (@isset($accounts) && !@empty($accounts))
                                            @foreach ($accounts as $info)
                                                {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                                <option @selected(old('account_number') == $info->employeeId) value="{{ $info->employeeId }} ">
                                                    {{ $info->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('account_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class=" col-4 ">
                                    <div class="form-group">
                                        <label>قيمة المبلغ المصروف</label>
                                        <input value="{{ old('transaction_money_value') }}"
                                            oninput="this.value=this.value.replace(/[^0-9.]/g,'');"
                                            name="transaction_money_value" id="transaction_money_value" class="form-control"
                                            placeholder="ادخل قيمة المبلغ المصروف  ">
                                        @error('transaction_money_value')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class=" col-8 ">
                                    <div class="form-group">
                                        <label> ملاحظات </label>
                                        <input type="text" name="note" id="note"
                                            value="{{ old('note', 'صرف مبلغ نظير ') }}" class="form-control">
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
                    <button class="btn btn-lg btn-success mb-2"> صرف </button>
                </div>
                </form>

                @if (count($data))
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th> رقم العملية </th>
                            <th> اسم الموظف </th>
                            <th> المبلغ المصروف</th>
                            <th>البيان</th>

                            <th>تاريخ الاضافة</th>

                        </thead>

                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->auto_serial }}</td>
                                    <td>{{ $info->employee_name }}</td>
                                    <td>{{ $info->transaction_money_value }}</td>
                                    <td>{{ $info->note }}</td>
                                    <td>
                                        {{ $info['created_at'] }}
                                        بواسطة
                                        {{ $info['user_name'] }}
                                    </td>


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
    <script src="{{ asset('assets/admin/js/treasuries.js') }}"></script>
    <script src="{{ asset('assets/admin/js/exchange_transaction.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>


@endsection
