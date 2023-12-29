@extends('layouts.admin')
@section('title', ' الضبط العام')
@section('contentheader', 'الخزن')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن </a>
@endsection


{{-- =======================================section content=================================================== --}}
@section('content')
    {{-- row class is mean a container in bootstrap --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تفاصيل الخزنة </h3>
                </div>

                <!-- /.card-body -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))

                        <table id="example2" class="table table-bordered table-hover">

                            <tr>
                                <td class="width30">اسم الخزنة</td>
                                <td>{{ $data['name'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">اخر ايصال صرف</td>
                                <td>{{ $data['last_bill_exchange'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">اخر ايصال تحصيل</td>
                                <td>{{ $data['last_bill_collect'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">حالة تفعيل الخزنة</td>
                                <td>
                                    @if ($data['active'] == 1)
                                        مفعل
                                    @else
                                        معطل
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="width30"> هل رئيسية</td>
                                <td>
                                    @if ($data['is_master'] == 1)
                                        نعم
                                    @else
                                        لا
                                    @endif
                                </td>
                            <tr>
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
                                    @if($data->updated_by>0 and $data->updated_by != null)
                                        {{ $data['updated_at'] }}
                                        بواسطة
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                    لا يوجد تحديث
                                    @endif
                                <a href="{{ route('admin.treasuries.edit', $data['id']) }}"
                                    class="btn btn-sm btn-success">تعديل</a>

                            </td>
                            </tr>

                        </table>

                        {{-- ---------------------secondary treasuries_delivery table details------------------------- --}}

                        <div class="card-header">
                            <h3 class="card-title card_title_center"> الخزن الفرعية التي سوف تسلم عهدتها الى الخزنة
                                <span class="btn-danger">{{ $data['name'] }}</span>
                                <div class="mt-3"> <a
                                        href="{{ route('admin.treasuries.add_treasuries_delivery', $data['id']) }}"
                                        class="btn btn-sm btn-primary mb-2">اضافة جديد</a>
                                </div>

                            </h3>
                        </div>
                        {{-- check if there are treasuries in the secondary 'treasuries_delivery' table --}}
                        {{-- 'treasuries_delivery' is a group of arrays --}}
                        @if (count($treasuries_delivery) )
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

                                    @foreach ($treasuries_delivery as $info)
                                         <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>{{ $info['created_at'] }}</td>
                                            <td><a
                                                    href='{{ route('admin.treasuries.delete_treasuries_delivery', $info->id) }}'class="btn btn-sm btn-danger are_you_sure">حذف</a>
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
@endsection
