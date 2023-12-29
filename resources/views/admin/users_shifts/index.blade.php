{{-- this page recevies one collection of objects called '$data' which contains data of all users_shifts  --}}

@extends('layouts.admin')
@section('title', ' شفتات الخزن')
@section('contentheader', ' حركة الخزينة ')
@section('contentheaderlink')
    <a href="{{ route('admin.users_shifts.index') }}">شفتات الخزن </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> بيانات شفتات الخزن للمستخدمين</h3>

                    {{-- you have to use 'csrf_token' because you use 'post' method in ajax search --}}
                    <input type="hidden" id="token_search" value="{{ csrf_token() }}">
                    {{-- <input type="hidden" id="ajax_search_url" value="{{ route('admin.units.ajax_search') }}"> --}}
                    {{-- @dd($current_shift_state) --}}
                    @if ($current_shift_state == 0 and $current_shift_state !== null)
                        <span style="color: red"> (يجب انهاء الشفت الحالي قبل فتح شفت جديد)</span>
                    @endif
                    <a href="{{ route('admin.users_shifts.create') }}" class="btn btn-sm btn-success"> فتح شفت جديد </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- ajax search --}}
                    {{-- <div class="row">
                        <div class="col-md-4">
                            <label> اسم الوحدة </label>
                            <input type="text" id="search_by_text" placeholder="بحث بالاسم" class="form-control">
                            <br>
                        </div>

                        <div class="form-group col-md-4">
                            <label> نوع الوحدة </label>
                            <select name="is_master_search" id="is_master_search" class="form-control">
                                <option value="all">الكل</option>
                                <option value="1">واحدة اساسية</option>
                                <option value="0">وحدة تجزئة</option>
                            </select>
                        </div>
                    </div> --}}

                    {{-- isset check if the variable isn't null --}}
                    <div id="ajax_search_div">
                        @if (@count($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>كود الشفت </th>
                                    <th>اسم المستخدم </th>
                                    <th>اسم الخزنة </th>
                                    <th> توقيت الفتح</th>
                                    <th> حالة المراجعة </th>
                                    <th>حالة الانتهاء </th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>

                                            <td>{{ $info->users_shiftsID }}
                                                <br>
                                                @if ($info->is_shift_finished == 0)
                                                    <span style="color: red"> الشيفت الحالي</span>
                                                @endif
                                            </td>
                                            <td>{{ $info->current_user_name }}</td>
                                            <td>{{ $info->treasury_name }}</td>
                                            <td>{{ $info->created_at }}</td>
                                            <td>
                                                @if ($info->is_reviewed)
                                                    <span style="color:rgb(0, 203, 0)"> تمت المراجعة</span>
                                                @else
                                                    <span style="color:red"> لم تتم المراجعة </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($info->is_shift_finished)
                                                    <span style="color:rgb(0, 203, 0)"> تم انهاء الشفت</span>
                                                @else
                                                    <span style="color:red"> لم يتم انهاء الشفت</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('admin.units.edit', $info->users_shiftsID) }}"
                                                    class=" mt-1 btn btn-sm btn-primary">طباعة الكشف</a>
                                                <a href="{{ route('admin.units.delete', $info->users_shiftsID) }}"
                                                    class=" mt-1 btn btn-sm btn-danger are_you_sure">كشف مختصر</a>
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

@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/inv_units.js') }}"></script>
@endsection
