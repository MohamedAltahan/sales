@extends('layouts.admin')
@section('title', 'الضبط العام')


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center">بيانات الضبط العام</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))

                        <table id="example2" class="table table-bordered table-hover">

                            <tr>
                                <td class="width30">اسم الشركه</td>
                                <td>{{ $data['system_name'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30">كود الشركه</td>
                                <td>{{ $data['com_code'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30">حاله الشركه</td>
                                <td>
                                    @if ($data['active'] == 1)
                                        مفعل
                                    @else
                                        معطل
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="width30">هاتف الشركه</td>
                                <td>{{ $data['phone'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30">عنوان الشركه</td>
                                <td>{{ $data['address'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30">رساله التنبيه للشركه</td>
                                <td>{{ $data['general_alert'] }}</td>
                            </tr>
                            <tr>
                                <td class="width30">لوجو الشركه</td>
                                <td>
                                    <div class="image">
                                        <img class="custom_img"
                                            src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}" alt="لوجو">
                                    </div>
                                </td>
                            <tr>
                                <td class="width30">تاريخ اخر تحديث </td>
                                <td>
                                    @if ($data['updated_by'] > 0 and $data['updated_at'] != null)
                                    
                                    {{-- if you want to custom the date formate use this code --}}
                                        {{-- @php
                                            // $dt = new DateTime($data['updated_at']);
                                            // $date = $dt->format('Y-m-d');
                                            //12 hour system
                                            // $time = $dt->format('h:i');
                                            // $newDateTime = date('A', strtotime($time));
                                            // $newDateTimeType = $newDateTime == 'AM' ? 'ص' : 'م';

                                        @endphp --}}
                                        {{ $data['updated_at'] }}
                                        {{-- {{ $time }} --}}
                                        {{-- {{ $newDateTimeType }} --}}
                                        بواسطة
                                        {{ $data['updated_by_admin'] }}
                                    @else
                                        لا يوجد تحديث
                                    @endif

                                </td>
                            </tr>
                            </tr>
                            <tr>
                        </table>
                    @else
                        <div class="alert alert-danger">
                            لا يوجد بيانات
                        </div>
                    @endif

                </div>
            </div>
            <div class="col-md-12 text-center">
                <a href="{{ route('admin.adminpanelsetting.edit') }}" class="btn btn-lg btn-success">تعديل</a>
            </div>
        </div>
    </div>

@endsection

@section('contentheader')
    الضبط
@endsection

@section('contentheaderlink')
    <a href="{{ route('admin.adminpanelsetting.index') }}"> الضبط </a>
@endsection



@section('contentheaderlink')
    contentheaderactive
@endsection
