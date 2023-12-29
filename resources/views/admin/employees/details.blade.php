@extends('layouts.admin')
@section('title', 'الموظفين')
@section('contentheader', 'حسابات الموظفين')
@section('contentheaderlink')
    <a href="{{ route('admin.employees.index') }}">الموظفين </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات الموظفين </h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.customers.ajax_search') }}">

                    <a href="{{ route('admin.employees.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    {{-- ----------------------search by name, account number, account type-------------------- --}}
                    {{-- <div class='row'> --}}
                    {{-- <div class="col-md-4"> --}}
                    {{-- <label style=" color : red"> بحث </label>

                            <input checked type="radio" name="radio_search" id="name" value="name">
                            <label for="name">بالاسم</label>
                            <input type="radio" name="radio_search" id="customer_code" value="customer_code">
                            <label for="customer_code"> كود العميل</label>

                            <input autofocus type="text" id="search_by_text"
                                placeholder=" ادخل اسم او كود العميل او رقم الحساب" class="form-control">
                        </div> --}}
                    {{-- end row class --}}
                    {{-- </div> --}}


                    {{-- ---------------------- ajax_search_div div used when you use ajax search ---------------------- --}}
                    {{-- isset check if the variable isn't null --}}
                    <div id="ajax_search_div">
                        @if (count($employeeDetails))
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th> رقم العملية </th>
                                    <th> اسم الموظف </th>
                                    <th> المبلغ المصروف</th>
                                    <th>البيان</th>

                                    <th>تاريخ الاضافة</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($employeeDetails as $info)
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
                            <div class="d-flex justify-content-center"> {{ $employeeDetails->links() }}</div>
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
    <script src="{{ asset('assets/admin/js/accounts.js') }}"></script>
@endsection
