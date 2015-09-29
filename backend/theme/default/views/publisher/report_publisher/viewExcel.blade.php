<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 	
</head>
<body>

<table>
	<tr>
		<td><strong>STT</strong></td>
		<td><strong>Họ tên</strong></td>
		<td><strong>Giới tính</strong></td>
	</tr>
    <?php  //print_r($item);exit();?>
	@foreach($item as $key=>$value)
	<tr>
		<td>1</td>
		<td>{{$value}}</td>
		<td>nam</td>
	</tr>
	@endforeach
	
</table>	

</body>
</html>
