@extends('layouts.admin')
@section('title', ' الحسابات')
@section('contentheader', ' انواع الحسابات ')
@section('contentheaderlink')
    <a href="{{ route('admin.accounts.index') }}">انواع الحسابات </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> انواع الحسابات</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    {{-- isset check if the variable isn't null --}}
                    <div id="ajax_search_div">
                        @if (@count($data))
                            @php
                                $i = 1;
                            @endphp
                            <table id="example2" class="table table-bordered table-hover">
                                <thead class="custom_thead">
                                    <th>مسلسل </th>
                                    <th>اسم النوع</th>
                                    <th>حالة التفعيل</th>
                                    <th> هل يضاف من شاشة داخلية</th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $info)
                                        <tr>

                                            <td>{{ $i }}</td>
                                            <td>{{ $info->name }}</td>
                                            <td>
                                                @if ($info->active == 1)
                                                    مفعل
                                                @else
                                                    معطل
                                                @endif
                                            </td>

                                            <td>
                                                @if ($info->related_internal_accounts == 1)
                                                    نعم
                                                @else
                                                    لا
                                                @endif
                                            </td>

                                        </tr>

                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <br>
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
