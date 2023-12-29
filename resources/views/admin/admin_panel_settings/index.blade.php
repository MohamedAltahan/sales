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
                                <td class="width30">هاتف الشركه</td>
                                <td>{{ $data['phone'] }}</td>
                            </tr>

                            <tr>
                                <td class="width30">عنوان الشركه</td>
                                <td>{{ $data['address'] }}</td>
                            </tr>

                            <td class="width30">تاريخ اخر تحديث </td>
                            <td>
                                @if ($data['updated_by'] > 0 and $data['updated_at'] != null)
                                    {{ $data['updated_at'] }}
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
            <div class="col-md-12 text-center mb-2 mt-2">
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
