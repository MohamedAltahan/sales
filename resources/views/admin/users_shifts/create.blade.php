{{-- this page recevies one collection of objects called '$current_user_treasuries' which contains 
the treasuries that user can access them  --}}

@extends('layouts.admin')
@section('title', ' شيفتات الخزن')
@section('contentheader', ' حركة الخزينة ')
@section('contentheaderlink')
    <a href="{{ route('admin.users_shifts.index') }}">
        شيفتات الخزن </a>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title card_title_center"> استلام خزنة لشيفت جديد</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    {{-- isset check if the variable isn't null --}}
                    <form action="{{ route('admin.users_shifts.store') }}" method="post">
                        @csrf
                        <label>بيانات الخزن المضافة لصلاحيات المستخدم</label>
                        <select name='treasury_id' class="form-control">
                            <option value="">اختار الخزنة المراد استلامها وبدء الشيفت</option>
                            {{-- isset check if the variable isn't null --}}
                            @if (@isset($current_user_treasuries) && !@empty($current_user_treasuries))
                                @foreach ($current_user_treasuries as $info)
                                    {{-- if the currnet shift is't finished yet disable the name of this treasury
                                    in order to nobody can use it  --}}
                                    <option value="{{ $info->treasury_id }}" @disabled($info->available == false)>
                                        {{ $info->treasury_name }}
                                        @if ($info->available == false)
                                            ***** غير متاح لانة قيد الاستخدام ولم يتم تسليم الشيفت****
                                        @endif
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('treasury_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <div class="text-center mt-3">
                            <button button class="btn btn-lg btn-success"> إضافة </button>
                            <a href="{{ route('admin.users_shifts.index') }}" class="btn btn-lg btn-danger">الغاء</a>
                        </div>
                    </form>

                </div>
                {{-- card body end --}}
            </div>
            {{-- card end --}}




        </div>
    </div>

@endsection
