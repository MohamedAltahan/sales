@extends('layouts.admin')
@section('title', ' تحصيل من عميل ')
@section('contentheader', 'تحصيل من عميل ')
@section('contentheaderlink')
    <a href="{{ route('admin.customers.index') }}">العملاء </a>
@endsection


@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> عرض بيانات الصنف </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead class="custom_thead">
                            <th>الاسم </th>
                            <th> الرصيد الحالي </th>
                        </thead>
                        <tbody>

                            <td>
                                {{ $data->name }}
                            </td>

                            @if ($data->current_balance < 0)
                                <td>{{ $data->current_balance * -1 }}
                                    <span style="color: red">مدين</span>
                                </td>
                            @elseif ($data->current_balance > 0)
                                <td>{{ $data->current_balance }}
                                    <span style="color: rgb(19, 179, 1)">له</span>
                                </td>
                            @else
                                <td>{{ $data->current_balance }}</td>
                            @endif

                        </tbody>
                    </table>
                    <form action="{{ route('admin.customers.update_balance', $data->id) }}" name="collectForm"
                        id="collectForm" method="post">
                        @csrf
                        <div class="row mt-4 ml-2">
                            <label class="mt-2">تحصيل مبلغ قيمتة</label>
                            <div class="col-5">
                                <input autofocus type="text" name="collect_money" id="collect_money"
                                    class="form-control">
                                @error('collect_money')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12 text-center mb-3">
                <button form="collectForm" class="btn btn-lg btn-success ">تحصيل</button>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                <a href="{{ route('admin.customers.all_transactions', $data->id) }}"class='btn btn-lg btn-info'>التحصيلات
                    السابقة</a>
            </div>
        </div>
    </div>

@endsection
