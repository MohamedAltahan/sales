{{-- we receive $data from controller which contains ( auto_serial, bill_final_total_cost, com_code, order_type) --}}
@if (!empty($data))
    {{-- if the bill still not approved --}}
    @if ($data['is_approved'] == 0)
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> اجمالي الاصناف بالفاتورة <span style="color: red">بدون ضريبة</span></label>
                    <input value="{{ $data['item_total_price'] }}" readonly name="item_total_price" id="item_total_price"
                        class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>نسبة ضريبة القيمة المضافة <span style="color: red">(%)</span></label>
                    <input value="{{ $data['tax_percent'] }}" name="tax_percent" id="tax_percent" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> قيمة الضريبة المضافة <span style="color: red">(بالجنية)</span></label>
                    <input readonly value="{{ $data['tax_value'] }}" name="units_per_parent" id="tax_value"
                        class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>الاجمالي <span style="color: red">بعد ضريبة</span></label>
                    <input readonly value="{{ $data['bill_total_cost_before_discount'] }}" name="units_per_parent"
                        id="bill_total_cost_before_discount" class="form-control">
                </div>
            </div>

            <div class="col-md-6">

                <label style="color: red"> نوع الخصم :</label>
                <input type="radio" name="radio_discount" id="nothing" value="0" checked>
                <label for="nothing">بدون خصم</label>

                <input type="radio" name="radio_discount" id="percentage" value="1">
                <label for="percentage"> خصم نسبة</label>

                <input type="radio" name="radio_discount" id="value" value="2">
                <label for="value"> خصم يدوي</label>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label class="discount_value" style="display: none"> قيمة الخصم
                        <span id='discountPercentage' style="display: none; color:red; ">بالنسبةالمئوية%</span>
                        <span id='discountPound' style="display: none; color:red "> بالجنية</span></label>
                    <input value="{{ $data['discount_value'] }}" name="discount_value" id="discount_value"
                        class="form-control discount_value" style="display: none">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group discount_value" style="display: none">
                    <label> القيمة المخصومة </label>
                    <input readonly value="{{ $data['discount_percent'] }}" name="discount_percent"
                        id="discount_percent" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> الاجمالي <span style="color: red"> بعد الخصم والضريبة</span></label>
                    <input readonly value="{{ $data['bill_final_total_cost'] }}" name="bill_final_total_cost"
                        id="bill_final_total_cost" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label> اسم خزنة الصرف </label>
                    <select class="form-control" id="treasury_id">
                        @if (!@empty($userShift))
                            <option selected value="{{ $userShift['treasury_id'] }}">{{ $userShift['treasury_name'] }}
                            </option>
                        @else
                            <option value=""> لا يوجد لديك خزنة</option>
                        @endif
                    </select>
                </div>
            </div>

            <div class=" col-6 ">
                <div class="form-group">
                    <label> الرصيد المتاح بالخزنة </label>
                    <input value="{{ $userShift['treasuryBalance'] }}" readonly name="treasuryBalance"
                        id="treasuryBalance" class="form-control">
                </div>
            </div>

            <div class=" col-6 ">
                <div class="form-group">
                    <label>نوع الفاتورة </label>
                    <select class="form-control" id="payment_type">
                        <option value="1" @selected($data['payment_type'] == 1)> كاش</option>
                        <option value="2" @selected($data['payment_type'] == 2)> اجل</option>
                    </select>
                </div>
            </div>

            <div class=" col-6 ">
                <div class="form-group">
                    <label> المدفوع للمورد </label>
                    <input class="form-control" {{-- اجل --}}
                        @if ($data['payment_type'] == 2) value="{{ $data['paid'] }}"
                    @else
                    {{-- كاش --}}
                    value="{{ $data['bill_final_total_cost'] }}"readonly @endif
                        name="paid" id="paid">
                </div>
            </div>

            <div class=" col-6 ">
                <div class="form-group">
                    <label> المتبقي للمورد </label>
                    <input class="form-control" {{-- اجل --}}
                        @if ($data['payment_type'] == 2) value="{{ $data['paid'] }}"
                @else
                {{-- كاش --}}
                value="{{ $data['remain'] }}" readonly @endif
                        name="remain" id="remain">

                </div>
            </div>

        </div>
    @else
        <div class="alert alert-danger">
            عفو القد تم اعتماد الفاتورة
        </div>
    @endif
@else
    <div class="alert alert-danger">
        لا يوجد تحديث
    </div>
@endif
<script src="{{ asset('assets/admin/js/supplierOrders.js') }}"></script>
