@if(count($datas) > 0 )
<tr class="website-{{$flight}}"><td  colspan="6"><h3 class="text-center text-website">Lists Wesite</h3></td></tr>
    @foreach($datas['summary'] as $data)

        <?php
        $frequency = 0;
        if ($data['total_impression'] > 0 && $data['total_unique_impression'] > 0) {
            $frequency = number_format(($data['total_impression'] + $data['total_impression_over']) / ($data['total_unique_impression'] + $data['total_unique_impression_over']), 2);
        }

        $ctr = 0;
        if ($data['total_click'] > 0 && $data['total_impression'] > 0) {
            $ctr = number_format(($data['total_click'] + $data['total_click_over']) / ($data['total_impression'] + $data['total_impression_over']) * 100, 2);
        }

        ?>
    <tr class="website-{{$flight}}">
        <td colspan="2" class="text-bold"> {{$data['website']['name']}}</td>
        <td>@if($datas['flight']['cost_type'] == "cpm") {{number_format($data['total_impression_over'] + $data['total_impression'])}} @else {{number_format($data['total_click'] + $data['total_click_over'])}} @endif</td>
        <td>{{$frequency}}</td>
        <td>{{$ctr}}</td>
        <td></td>
    </tr>
    @endforeach
@endif