<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	{{ HTML::style("{$assetURL}css/excel.css") }}
</head>
<body>

<table>
	<tr class="mb12"><th colspan="2" class="brand" valign="middle">Yomedia Digital - Conversion Report</th></tr>
	<tr><th align="center">Conversion Name:</th><th align="center" >{{$conversion->name}}</th></tr>
</table>

<table class="table" border="1">
    <tr>
    	<th align="center">Time</th>
        <th align="center">Param</th>
    </tr>
	
	@if(!empty($listConversionTracking) )
	@foreach($listConversionTracking as $item)
		<tr>
			<td>{{date('H:i:s d/m/Y', strtotime($item->created_at))}}</td>
			<td>
				<?php
				    $arrParam = json_decode($item->param);
				?>
				@if (!empty($arrParam))
					@foreach ($arrParam as $key=>$value)
						{{$key}}: {{$value}}<br />
					@endforeach
				@endif
			</td>
		</tr>
	@endforeach
@endif
</table>

</body>
</html>