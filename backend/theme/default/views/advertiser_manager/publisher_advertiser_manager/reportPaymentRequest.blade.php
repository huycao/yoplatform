<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	{{ HTML::style("{$assetURL}css/excel.css") }}
</head>
<body>
<table>
	<tr>
		<td colspan="3">Tên công ty : .....................................</td>
		<td colspan="3">Khách hàng : CÔNG TY CỔ PHẦN NEW PINE MULTIMEDIA TECHNOLOGIES</td>
	</tr>
	<tr>
		<td colspan="3">Địa chỉ     : .....................................</td>
		<td colspan="3">Địa chỉ     : 28 Phùng Khắc Khoan, Phường Đa Kao, Quận 1, TP.HCM</td>
	</tr>
	<tr>
		<td colspan="3">Mã số thuế  : .....................................</td>
		<td colspan="3">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3">Điện thoại  : .....................................</td>
		<td colspan="3">Điện thoại  : (08) 6281 7605</td>
	</tr>
	<tr>
		<td colspan="3">Số FAX      : .....................................</td>
		<td colspan="3">Số FAX      : (08) 6281 7605</td>
	</tr>
</table>
<table>
	<tr><td colspan="6" align="center" style="font-size:18px">BẢNG KÊ CHI TIẾT QUẢNG CÁO</td></tr>
	<tr><td colspan="6" align="center">(Số...................... Ngày..................................)</td></tr>
	<tr><td colspan="6" align="left">Kèm theo Hóa Đơn Số: ...................... Ngày.........tháng.........năm.........</td></tr>
	<tr><td colspan="6" align="left">Thời gian: {{date('Y-m', strtotime($data[0]->created_at))}}</td></tr>
	<tr><td colspan="6" align="left">Publisher: {{!empty($pubName) ? $pubName : ''}}</td></tr>
	<tr><td colspan="6">&nbsp;</td></tr>
</table>
<table class="table" border="1">
	<tr>
		<th align="center">STT</th>
		<th align="center">Chương trình</th>
		<th align="center">Số tiền</th>
		<th align="center">Lượt hiển thị</th>
		<th align="center">Lượt nhấp vào quảng cáo</th>
		<th align="center">Tỉ lệ nhấp vào quảng cáo/Lượt hiển thị</th>
	</tr>
<?php
	$totalImpression = 0;
	$totalClick      = 0;
	$totalAmount     = 0;
?>
@if(  !empty($data) )
	<?php $stt = 0; ?>
	@foreach( $data as $item )
	<?php 
		$stt++; 
		$totalImpression += $item->impression;
		$totalClick      += $item->click;
		$totalAmount     += $item->amount;
	?>
	<tr>
		<td align="center">{{$stt}}</td>
		<td>{{$item->campaign->name}}</td>
		<td>{{$item->amount}}</td>
		<td>{{$item->impression}}</td>
		<td>{{$item->click}}</td>
		<td align="right">{{number_format($item->ctr *100, 2)}}%</td>
	</tr>
	@endforeach
	<?php
	if($totalAmount == 0){
		$vat = 0;
	}else{
		$vat = $totalAmount * 10 / 110;
	}
	?>
	<tr>
		<th class="border-dash"></th>
		<th align="center" class="border-dash">Tổng cộng (bao gồm thuế GTGT)</th>
		<th class="border-dash">{{$totalAmount}}</th>
		<th class="border-dash">{{$totalImpression}}</th>
		<th class="border-dash">{{$totalClick}}</th>
		<th class="border-dash">
		</th>
	</tr>

	<tr>
		<th class="border-dash"></th>
		<th align="center" class="border-dash">Thuế GTGT 10%</th>
		<th class="border-dash">{{$vat}}</th>
		<th class="border-dash"></th>
		<th class="border-dash"></th>
		<th class="border-dash"></th>
	</tr>
	<tr>
		<th class="border-dash"></th>
		<th align="center" class="border-dash">Số tiền (gồm thuế GTGT)</th>
		<th class="border-dash">{{$totalAmount - $vat}}</th>
		<th class="border-dash"></th>
		<th class="border-dash"></th>
		<th class="border-dash"></th>
	</tr>
@endif
</table>
<table>
	<tr><td colspan="6">(Bằng chữ:......................................................................................................................................................................................................)</td></tr>
	<tr></tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td align="center" colspan="2">Ngày........... Tháng............Năm...........</td>
	</tr>
	<tr>
		<td></td>
		<td align="center" colspan="2"><b>{{$publisher->company}}</b></td>
		<td></td>
		<td align="center" colspan="2"><b>CÔNG TY CỔ PHẦN NEW PINE MULTIMEDIA TECHNOLOGIES</b></td>
	</tr>
	<tr>
		<td></td>
		<td align="center" colspan="2">(Ký, ghi rõ Họ Tên và đóng dấu)</td>
		<td></td>
		<td align="center" colspan="2">(Ký, ghi rõ Họ Tên và đóng dấu)</td>
	</tr>

</table>
</body>
</html>