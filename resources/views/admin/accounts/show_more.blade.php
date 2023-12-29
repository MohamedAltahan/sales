@extends('layouts.admin')
@section('title', ' مزيد من التفاصيل ')
@section('contentheader', ' تفاصيل الصنف ')
@section('contentheaderlink')
    <a href="{{ route('admin.items.index') }}">الاصناف </a>
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
                    {{-- isset check if the variable isn't null --}}
                    @if (@isset($data) && !@empty($data))

                        <table id="example2" class="table table-bordered table-hover">
                            <tr >
                                <td colspan="4">
                                    <label>  كود الصنف الثابت  </label><br>
                                    {{ $data->item_code }}
                                </td>
                            </tr>
                            {{-- first row --}}
                            <tr>
                                <td>
                                    <label> اسم الصنف </label><br>
                                    {{ $data->name }}
                                </td>
                                <td>
                                    <label> باركود الصنف </label><br>
                                    {{ $data->barcode }}
                                </td>
                                <td>
                                    <label> نوع الصنف </label><br>
                                    @if ($data->item_type == 1)
                                        مخزني
                                    @elseif ($data->item_type == 2)
                                        استهلاكي بتاريخ صلاحية
                                    @elseif ($data->item_type == 3)
                                        عهدة
                                    @endif
                                </td>
                                <td>
                                    <label> فئة الصنف </label><br>
                                    {{ $data->inv_item_category_name }}
                                </td>
                            </tr>
                            {{-- second row --}}
                            <tr>
                                <td>
                                    <label>هل للصنف سعر ثابت</label><br>
                                    @if ($data->has_fixed_price == 0)
                                    لا السعر قابل للتفاوض
                                    @elseif ($data->has_fixed_price == 1)
                                        نعم السعر ثابت
                                    @endif
                                </td>
                                <td>
                                    <label> حالة تفعيل الصنف </label><br>
                                    @if ($data->active == 0)
                                    غير مفعل
                                    @elseif ($data->active == 1)
                                      مفعل
                                    @endif
                                </td>
                                <td>
                                    <label> الصنف الاساسي التابع له الصنف </label><br>
                                    {{ $data->primary_item_name }}
                                </td>
                                <td>
                                    <label> وحدة القياس الرئيسية </label><br>
                                    {{ $data->primary_unit_name }}
                                </td>
                            </tr>
                            {{-- third row --}}
                            <tr>
                                <td @if ($data->has_retailunit == 0) colspan='3' @endif>
                                    <label> هل للصنف وحدة تجزيئة</label><br>
                                    @if ($data->has_retailunit == 0)
                                        لا
                                    @elseif ($data->has_retailunit == 1)
                                        نعم
                                    @endif
                                </td>
                                @if ($data->has_retailunit == 1)
                                    <td>
                                        <label> وحدة قياس التجزيئة</label><br>
                                        {{ $data->retail_unit_name }}
                                    </td>
                                    <td>
                                        <label> عدد وحدات التجزيئه داخل الوحدة الاساسة</label><br>
                                        {{ $data->units_per_parent * 1 }}
                                    </td>
                                @endif
                            </tr>
                            {{-- 5th row --}}
                            <tr >
                                @if ($data->has_retailunit == 1)
                                <td colspan="1">
                                    <label> **تكلفة الشراء على الشركة لل <span
                                            style="color:red">({{ $data->retail_unit_name }})</span></label><br>
                                    {{ $data->secondary_cost * 1 }}
                                </td>
                                <td>
                                    <label> السعر قطاعي لوحدة التجزئة <span
                                            style="color:red">({{ $data->retail_unit_name }})</span> </label><br>
                                    {{ $data->secondary_retail_price * 1 }}
                                </td>

                                <td>
                                    <label> السعر نصف جملة لوحدة التجزئة <span
                                            style="color:red">({{ $data->retail_unit_name }})</span></label><br>
                                    {{ $data->secondary_half_wholesale_price * 1 }}
                                </td>
                                <td>
                                    <label> السعر جملة لوحدة التجزئة <span
                                            style="color:red">({{ $data->retail_unit_name }})</span></label><br>
                                    {{ $data->secondary_wholesale_price * 1 }}
                                </td>
                                @endif
                            </tr>

                            {{-- 4th row --}}
                            <tr>
                                <td>
                                    <label> **تكلفة الشراء على الشركة لل <span
                                            style="color:red">({{ $data->primary_unit_name }})</span> </label><br>
                                    {{ $data->primary_cost * 1 }}
                                </td>
                                <td>
                                    <label> السعر قطاعي للوحدة الاساسية <span
                                            style="color:red">({{ $data->primary_unit_name }})</span> </label><br>
                                    {{ $data->primary_retail_price * 1 }}
                                </td>

                                <td>
                                    <label> السعر نص جملة للوحدة الاساسية<span
                                            style="color:red">({{ $data->primary_unit_name }})</span></label><br>
                                    {{ $data->primary_half_wholesale_price * 1 }}
                                </td>
                                <td>
                                    <label> السعر جملة للوحدة الاساسية<span
                                            style="color:red">({{ $data->primary_unit_name }})</span></label><br>
                                    {{ $data->primary_wholesale_price * 1 }}
                                </td>
                            </tr>


  {{-- third row --}}
  <tr>

    @if ($data->has_retailunit == 1)
        <td>
            <label> وحدة قياس التجزيئة</label><br>
            {{ $data->retail_unit_name }}
        </td>
        <td>
            <label> عدد وحدات التجزيئه داخل الوحدة الاساسة</label><br>
            {{ $data->units_per_parent * 1 }}
        </td>
    @endif
</tr>



                            <td class="width30">صورة الصنف </td>
                            <td>
                                <div class="image">
                                    <img class="custom_img"
                                        src="{{ asset('assets/admin/uploads') . '/' . $data['photo'] }}" alt="لوجو">
                                </div>
                            </td>
                            <tr>
                                <td class="width30">تاريخ اخر تحديث </td>
                                <td colspan="3">
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
            <div class="col-12 text-center mb-3">
                <a href="{{ route('admin.items.edit', $data->id) }}" class="btn btn-lg btn-success ">تعديل</a>
                <a href="{{ route('admin.items.index') }}" class="btn btn-lg btn-danger">الغاء</a>
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
