@extends('layouts.admin')
@section('title', 'الموردين')
@section('contentheader', 'الحسابات')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الموردين </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات الموردين </h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.suppliers.ajax_search') }}">

                    <a href="{{ route('admin.suppliers.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">


                    {{-- -----------------------search by name, account number, account type-------------------- --}}
                    <div class='row'>
                        <div class="col-md-4">
                            <label style=" color : red"> بحث </label>

                            <input checked type="radio" name="radio_search" id="radio_search" value="name"> بالاسم
                            <input type="radio" name="radio_search" id="radio_search" value="supplier_code"> كود المورد

                            <input autofocus autofocus type="text" id="search_by_text"
                                placeholder=" ادخل اسم او كود المورد او رقم الحساب" class="form-control">
                        </div>
                        {{-- end row class --}}
                    </div>
                    <br>

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
                                    <th>نوع المورد </th>
                                    <th>كود المورد </th>
                                    <th> الرصيد </th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->supplier_type_name }}</td>
                                            <td>{{ $info->supplier_code }}</td>
                                            <td>{{ $info->current_balance }}</td>

                                            <td>
                                                <a href="{{ route('admin.suppliers.edit', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.suppliers.delete', $info->id) }}"
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
    <script src="{{ asset('assets/admin/js/suppliers.js') }}"></script>
@endsection
