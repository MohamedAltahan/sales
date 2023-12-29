<tr>
    <td>{{ $item_name }}</td>
    <td>{{ $data['chassisWidthValue'] }}</td>
    <td>{{ $data['quantity'] }}</td>
    <td>{{ $data['unit_price'] * 1 }}</td>
    <td>{{ $data['total_unit_price'] * 1 }}</td>
    <td>
        <button class=" mt-1 btn btn-sm btn-danger remove are_you_suree" value="{{ $data['item_serial'] }}">حذف</button>
    </td>
</tr>
