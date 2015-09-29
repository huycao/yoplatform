<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
	{{ HTML::style("{$assetURL}css/excel.css") }}
</head>
<body>

<table>
	<tr class="mb12"><th colspan="4" class="brand" valign="middle">Yomedia Digital - Flight Report Summary</th></tr>
	<tr><th align="center">Campaign Name:</th><th colspan="3" align="center" >{{$campaign->name}}</th></tr>
	<tr><th align="center">Duration:</th><th colspan="3" align="center">{{$campaign->dateRange}}</th></tr>
	<tr><th align="center">Advertise:</th><th colspan="3" align="center">{{$campaign->advertiser->name}}</th></tr>
	<tr><th align="center">Agency:</th><th colspan="3" align="center">{{$campaign->agency->name}}</th></tr>
</table>


<table class="table" border="1">
	<tr>
        <th>ID</th>
        <th>Conversion</th>
        <th>Source</th>
        <th>Total conversion</th>
    </tr>

    @if(!empty($listConversionSummary))
        @foreach($listConversionSummary as $tracking)
            <tr>
                <td>{{$tracking['conversion']['id']}}</td>
                <td class="nameflight">{{$tracking['conversion']['name']}}</td>
                <td>{{$tracking['conversion']['source']}}</td>
                <td class="text-center">{{number_format($tracking['total_conversion'])}}</td>
            </tr>
        @endforeach
    @endif

</table>


</body>
</html>