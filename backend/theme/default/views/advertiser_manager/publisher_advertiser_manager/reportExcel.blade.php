<?php

?>
<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    {{ HTML::style("{$assetURL}css/excel.css") }}
</head>
<body>

<table>
    <tr class="mb12">
        <th class="" valign="middle"></th>
        <th colspan="10" class="brand_t" valign="middle">TỔNG HỢP THANH TOÁN PUBLISHER TỪNG THÁNG</th>
        <th class="" valign="middle"></th>
    </tr>
    <tr>
        <th class="brand" valign="middle">Sitelist</th>
    @foreach($data as $flight=> $dataflight)
            <th class="brand" valign="middle">{{ $flight }}</th>
    @endforeach
        <th  class="brand" valign="middle">TOTAL</th>
    </tr>

    @foreach($dataSite as $site=> $itemsite)
        @if($itemsite > 0)
        <?php $sumitem = 0;?>
    <tr>
        <td  class="brand_r">{{ $site }}</td>
        @foreach($data as $flight=> $dataflight)
            @if(isset($data[$flight]) && isset($data[$flight][$site]))
                <td align="right">
                    @if($data[$flight][$site] == 0)
                        0
                    @else
                        <?php
                        $sumitem += (int) $data[$flight][$site];
                        ?>
                        {{ $data[$flight][$site] }}

                    @endif</td>
            @else
                <td></td>
            @endif
        @endforeach
        <td align="right">{{ $sumitem }}</td>
    </tr>
        @endif
    @endforeach
</table>


</body>
</html>