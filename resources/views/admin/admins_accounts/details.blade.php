@extends('layouts.admin')
@section('title', 'الصلاحيات')
@section('contentheader', ' المستخدمين')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}">المستخدمين </a>
@endsection


{{-- =======================================section content=================================================== --}}
@section('content')
    {{-- row class is mean a container in bootstrap --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تفاصيل المستخدم </h3>
                </div>

                <!-- /.card-body -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))

                        <table id="example2" class="table table-bordered table-hover">

                            <tr>
                                <td class="width30">اسم المستخدم</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">حالة التفعيل </td>
                                <td>
                                    @if ($data['active'] == 1)
                                        مفعل
                                    @else
                                        معطل
                                    @endif
                                </td>
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
                                <a href="{{ route('admin.admins_accounts.edit', $data['id']) }}"
                                    class="btn btn-sm btn-success">تعديل</a>
                            </td>
                            </tr>

                        </table>

                        {{-- ---------------------secondary treasuries_delivery table details------------------------- --}}

                        <div class="card-header">
                            <h3 class="card-title card_title_center"> الخزن المضافة لصلاحيات المستخدم
                                <span class="btn-danger">{{ $data['name'] }}</span>
                                <div class="mt-3">
                                    <button data-toggle='modal' data-target='#add_treasuries_modal'
                                        class="btn btn-sm btn-primary mb-2">اضافة خزنة جديدة للمستخدم</button>
                                </div>

                            </h3>
                        </div>
                        {{-- check if there are treasuries in the secondary 'treasuries_delivery' table --}}
                        {{-- 'treasuries_delivery' is a group of arrays --}}
                        @if (count($treasuries_admins))
                            @php
                                // serial number
                                $i = 1;
                            @endphp
                            <table class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>اسم الخزنه</th>
                                    <th>تاريخ الاضافة </th>
                                    <th></th>
                                </thead>

                                <tbody>

                                    @foreach ($treasuries_admins as $info)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info['created_at'] }} بواسطة {{ $info['add_by_admin'] }}</td>
                                            <td><a
                                                    href='{{ route('admin.treasuries.delete_treasuries_delivery', $info->treasuries_admins_id) }}'class="btn btn-sm btn-danger are_you_sure">حذف</a>
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                لا يوجد بيانات
                            </div>
                        @endif

                        {{-- End_treasuries_delivery --}}
                    @else
                        <div class="alert alert-danger">
                            لا يوجد بيانات
                        </div>
                    @endif
                    {{-- end card body class --}}
                </div>
                {{-- end card class --}}
            </div>

            {{-- end class="col-12" --}}
        </div>
        {{-- end class 'row' --}}
    </div>
    {{-- end section content --}}

    {{-- -------------------------------------modal 'edit item' using ajax  ---------------------------------------- --}}
    <div class="modal" id="add_treasuries_modal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-primary">
                <div class="modal-header">
                    <h4 class="modal-title"> إضافة خزن للمستخدمين</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body " id="add_treasuries_modal_body"
                    style="background-color:white; color: black !important">

                    <form action="{{ route('admin.admins_accounts.add_treasuries_to_admin', $data->id) }}" method="post">
                        @csrf
                        <label>بيانات الخزن </label>
                        <select name='treasury_id' id='treasury_id' class="form-control">
                            <option value="">اختار الخزنة </option>
                            {{-- isset check if the variable isn't null --}}
                            @if (@isset($treasuries) && !@empty($treasuries))
                                @foreach ($treasuries as $info)
                                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                    <option value="{{ $info->id }}">{{ $info->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
                    <div class="text-center">
                        <button type="submit" class="btn  btn-success "> اضافة الخزنة للمستخدم</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
    {{-- ----------------------------------end modal 'edit item' using ajax  ---------------------------------------- --}}

@endsection
