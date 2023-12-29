@extends('layouts.admin')
@section('title', ' المشتريات')
@section('contentheader', ' حركات مخزنية ')
@section('contentheaderlink')
    <a href="{{ route('admin.supplier_orders.index') }}">فواتير المشتريات </a>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة فاتورة مشتريات من مورد</h3>
                </div>

                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    <form action="{{ route('admin.supplier_orders.store') }}" method="post">
                        @csrf
                        <div class="row">

                            <div class=" col-5 ">
                                <div class="form-group">
                                    <label> تاريخ الفاتورة </label>
                                    <input type="date" value="{{ now()->format('Y-m-d') }}" name="order_date"
                                        id="order_date" class="form-control">
                                    @error('order_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" col-5 ">
                                <div class="form-group">
                                    <label> رقم الفاتورة الخاص بشركة المورد</label>
                                    <input type="text" name="doc_no" id="doc_no" value="{{ old('doc_no') }}"
                                        class="form-control">
                                    @error('doc_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class=" col-5 ">
                                <label> بيانات المورد</label>
                                <select name='supplier_code' class="form-control select2">
                                    <option value="">اختار اسم المورد</option>
                                    {{-- isset check if the variable isn't null --}}
                                    @if (@isset($Suppliers) && !@empty($Suppliers))
                                        @foreach ($Suppliers as $info)
                                            {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                            <option @selected(old('supplier_code') == $info->supplier_code) value="{{ $info->supplier_code }}">
                                                {{ $info->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('supplier_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class=" col-5 ">
                                <div class="form-group">
                                    <label> ملاحظات </label>
                                    <input name="notes" type="text" value="{{ old('notes') }}" id="notes"
                                        class="form-control">
                                    @error('notes')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- end row div --}}
                        </div>
                        <div class="text-center">
                            <button button class="btn btn-lg btn-success"> إضافة </button>
                            <a href="{{ route('admin.supplier_orders.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                        </div>
                    </form>

                </div>
                {{-- card body end --}}
            </div>
            {{-- card end --}}
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    </script>

@endsection
