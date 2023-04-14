@extends('layouts.admin')
@section('title', 'اضافة خزنة جديدة')
@section('contentheader', 'الخزن')
@section('contentheaderlink')
    <a href="{{ route('admin.treasuries.index') }}"> الخزن الفرعية للاستلام  </a>
@endsection
@section('contentheaderactive', 'اضافة')


@section('content')
    {{-- 'row' is a container --}}
    <div class="row">
        {{-- "col-12" is all the page width --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> اضافة خزنه لكى تستلم منها
                       <span class="btn-danger ">{{ $data['name'] }} </span>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.treasuries.store_treasuries_delivery', $data->id) }}" method="post">
                        @csrf

                        <select name='treasuries_tobe_delivered_id' class="form-control">
                            <option value="">اختار الخزنة الفرعية</option>
                            {{-- isset check if the variable isn't null --}}
                            @if (@isset($treasuries) && !@empty($treasuries))
                                @foreach ($treasuries as $info)
                                    {{-- if error happen when you add new secondary treasuriy keep the chosen value --}}
                                    <option @selected(old('treasuries_tobe_delivered_id') == $info->id)
                                        value="{{ $info->id }}">{{ $info->name }}</option>
                                @endforeach
                            @endif
                        </select>

                        @error('treasuries_tobe_delivered_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    {{-- end card body div --}}
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-lg btn-success mb-3">حفظ التعديلات</button>
                    <a href="{{ route('admin.treasuries.index') }}" class="mb-3 btn btn-lg btn-danger">الغاء</a>
                </div>

                </form>
                {{-- card body end --}}
            </div>
            {{-- col-12 end --}}
        </div>
        {{-- end row div --}}
    </div>

@endsection
