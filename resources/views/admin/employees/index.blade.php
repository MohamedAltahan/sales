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
                        @if (@count($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>كود الموظف </th>
                                    <th>الاسم </th>
                                    <th> الرصيد </th>
                                    <th>تاريخ الاضافة</th>
                                    <th>تاريخ اخر تعديل</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->employeeId }}</td>
                                            <td>{{ $info->name }}</td>

                                            @if ($info->current_balance < 0)
                                                <td>{{ $info->current_balance * -1 }}
                                                    <span style="color: red">مدين</span>
                                                </td>
                                            @elseif ($info->current_balance > 0)
                                                <td>{{ $info->current_balance }}
                                                    <span style="color: rgb(19, 179, 1)">له</span>
                                                </td>
                                            @else
                                                <td>{{ $info->current_balance }}</td>
                                            @endif
                                            <td>{{ $info->created_at }}</td>
                                            <td>{{ $info->updated_at }}</td>

                                            <td>
                                                <a href="{{ route('admin.employees.edit', $info->employeeId) }}"
                                                    class=" mt-1 btn btn-sm btn-primary">تعديل</a>

                                                <a href="{{ route('admin.employees.details', $info->employeeId) }}"
                                                    class=" mt-1 btn btn-sm btn-info ">التفاصيل </a>


                                                <a href="{{ route('admin.employees.delete', $info->employeeId) }}"
                                                    class=" mt-1 btn btn-sm btn-danger are_you_sure mr-2 ml-3">حذف</a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="d-flex justify-content-center"> {{ $data->links() }}</div>
                        @else
                            <div class="alert alert-danger">
                                لا يوجد بيااانات
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
