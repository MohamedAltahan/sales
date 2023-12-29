@extends('layouts.admin')
@section('title', 'الحسابات')
@section('contentheader', ' الحسابات المالية ')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">الحسابات المالية </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card col-12">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات الحسابات المالية</h3>
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    <input type="hidden" id="ajax_search_url" value="{{ route('admin.accounts.ajax_search') }}">

                    <a href="{{ route('admin.accounts.create') }}" class="btn btn-sm btn-success">اضافه جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">


                    {{-- -----------------------search by name, account number, account type-------------------- --}}
                    <div class='row'>
                        <div class="col-md-4">
                            <label style=" color : red"> بحث </label>

                            <input checked type="radio" name="radio_search" id="radio_search" value="name"> بالاسم
                            <input type="radio" name="radio_search" id="radio_search" value="account_number"> برقم الحساب
                            <input type="text" id="search_by_text" placeholder=" ادخل (اسم - رقم) الحساب"
                                class="form-control">
                        </div>

                        <div class=" col-md-4 ">
                            <label> نوع الحساب</label>
                            <select name='account_type_id_search' id='account_type_id_search' class="form-control">
                                <option value='all'> بحث بالكل</option>
                                {{-- isset check if the variable isn't null --}}
                                @if (@isset($account_types) && !@empty($account_types))
                                    @foreach ($account_types as $info)
                                        {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                        <option value="{{ $info->id }}"> {{ $info->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            {{-- end accout type div --}}
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>هل الحساب اساسي </label>
                                <select name="is_primary_search" id="is_primary_search" class="form-control">
                                    <option value="all">بحث بالكل</option>
                                    <option value="0">لا</option>
                                    <option value="1">نعم </option>
                                </select>
                            </div>
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
                                    <th>الاسم </th>
                                    <th>رقم الحساب </th>
                                    <th>النوع</th>
                                    <th> هل اساسي</th>
                                    <th> الحساب الاساسي</th>
                                    <th> الرصيد </th>
                                    <th>حالة التفعيل</th>

                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info->account_number }}</td>
                                            <td>{{ $info->account_type_name }}</td>
                                            <td>
                                                @if ($info->is_primary == 1)
                                                    نعم
                                                @else
                                                    لا
                                                @endif
                                            </td>
                                            <td>{{ $info->primary_account_name }}</td>
                                            <td></td>

                                            <td>
                                                @if ($info->active == 1)
                                                    مفعل
                                                @else
                                                    معطل
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.accounts.edit', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-primary">تعديل</a>
                                                <a href="{{ route('admin.accounts.delete', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-danger are_you_sure">حذف</a>
                                                <a href="{{ route('admin.accounts.show', $info->id) }}"
                                                    class=" mt-1 btn btn-sm btn-info">المزيد</a>
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
