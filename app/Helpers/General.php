<?php

use Illuminate\Support\Facades\Config;
//=====================================upload photo=======================================================
//it take the path where we need to store the uploaded photo, and the  photo name
function uploadImage($folder, $image)
{
    // to get the extention of the photo and convert it to smallcase
    $extension = strtolower($image->extension());
    //to rename the photo with random name
    $filename = time() . rand(100, 999) . '.' . $extension;
    //to change the name and store it really
    $image->getClintOrignalName = $filename;
    $image->move($folder, $filename);
    return $filename;
}
//========================================================================================================

//===================================get cols by pagination=======================================================
function getColumns_p($model, $columnsName = [], $where = [], $orderField, $orderType, $paginationCounter)
{
    $data = $model
        ::select($columnsName)
        ->where($where)
        ->orderby($orderField, $orderType)
        ->paginate($paginationCounter);
    return $data;
}

//===================================get cols=============================================================
function getColumns($model, $columnsName = [], $where = [], $orderField, $orderType)
{
    //this will retuen collection not object, because the query ends with get()
    $data = $model
        ::select($columnsName)
        ->where($where)
        ->orderby($orderField, $orderType)
        ->get();
    return $data;
}
//===================================get all rows=============================================================
function getAllRows($model, $columnsName = [], $orderField, $orderType)
{
    //this will retuen collection not object, because the query ends with get()
    $data = $model
        ::select($columnsName)
        ->orderby($orderField, $orderType)
        ->get();
    return $data;
}
//===================================get valu=============================================================
//get value of thing
function getValue($model, $where = [], $fieldName)
{
    return $data = $model::where($where)->value($fieldName);
}

//===================================get last or first row================================================

//get last or first row depends on "DESC"(last) or "ACS"(first)
function getLastRow($model, $columnsName = [], $where = [], $orderField, $orderType)
{
    //this will return one object because the query ends with first()
    $data = $model
        ::select($columnsName)
        ->where($where)
        ->orderby($orderField, $orderType)
        ->first();
    return $data;
}

//===================================get one row=============================================================
function getOneRow($model, $columnsName = [], $where = [])
{
    //this will return one object because the query ends with first()
    //you may select all the columns using '*' or select some columns
    $data = $model
        ::select($columnsName)
        ->where($where)
        ->first();
    return $data;
}
//===================================get one row using 2where =============================================================

function getOneRow_2where($model, $columnsName = [], $where = [], $where2 = [])
{
    //this will return one object because the query ends with first()
    //you may select all the columns using '*' or some columns
    $data = $model
        ::select($columnsName)
        ->where($where)
        ->where($where2)
        ->first();
    return $data;
}

//===================================sum =============================================================
function getSum($model, $where = [], $fieldName)
{
    //this will return one object because the query ends with first()
    //you may select all the columns using '*' or some columns
    $sum = $model
        ::where($where)
        ->sum($fieldName);
    return $sum;
}
//=================================== end sum =============================================================

//===================================update =============================================================
function update($model, $where = [], $newValue = [])
{
    //this will return one object because the query ends with first()
    //you may select all the columns using '*' or some columns
    $flag = $model
        ::where($where)
        ->update($newValue);
    return $flag;
}
//=================================== end update =============================================================

//===================================create ==================================================================
function create($model, $newValue = [])
{
    //this will return one object because the query ends with first()
    //you may select all the columns using '*' or some columns
    $flag = $model
        ::create($newValue);
    return $flag;
}
//=================================== end create =============================================================
//check if there is an open shift
//receives there models 
//Users_shift() to  get data about the current shift
//Treasuries_transaction() to get the current balance of the current treasury
//Treasuries() to get the name of the curruent treasury
function getUserShift($model, $model2, $model3)
{
    $com_code = auth()->user()->com_code;
    $current_user_id = auth()->user()->id;
    // if there is an open shift get some data about it 'user_id', 'shift_code', 'is_shift_finished', 'treasury_id'].
    $current_shift_state = getOneRow(
        $model,
        ['user_id', 'shift_code', 'is_shift_finished', 'treasury_id'],
        ['com_code' => $com_code, 'user_id' => $current_user_id, 'is_shift_finished' => 0]
    );
    // if there is an open shift
    if (!empty($current_shift_state)) {
        //get current balance of current opening shift
        $current_shift_state['treasuryBalance'] = $model2::where(['com_code' => $com_code, 'shift_code' => $current_shift_state['shift_code']])->sum('transaction_money_value');
        //get the name of the current shift treasury
        $current_shift_state['treasury_name'] = $model3::where(['com_code' => $com_code, 'id' => $current_shift_state['treasury_id']])->value('name');
    }
    return $current_shift_state;
}
