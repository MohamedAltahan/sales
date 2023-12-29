@extends('layouts.admin')
@section('title', ' التحصيلات السابقة')
@section('contentheader', 'التحصيلات السابقة')
@section('contentheaderlink')
    <a href="{{ route('admin.customers.index') }}">العملاء </a>
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> تحصيلات-{{ $name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-sm table-hover">
                        <thead class="custom_thead">
                            <th>نوع التحصيل </th>
                            <th> قيمة التحصيل </th>
                            <th> تاريخ التحصيل </th>

                        </thead>
                        <tbody>

                            @foreach ($data as $info)
                                <tr>

                                    @if ($info->transaction_type == 1)
                                        <td><span style="color: rgb(0, 177, 0)">سداد</span> </td>
                                    @elseif ($info->transaction_type == 0)
                                        <td><span style="color: rgb(255, 39, 39)">مديونية</span> </td>
                                    @endif

                                    <td>{{ $info->transaction_value }} </td>
                                    <td>{{ $info->created_at }} </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>

@endsection
