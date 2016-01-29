<table>
  <thead>
    <tr>
      <th colspan="6" align="center" valign="middle" height="35">Report ({{$start_date}} - {{$end_date}})</th>
    </tr>
    <tr valign="middle" height="18">
      <th align="center">Campaign</th>
      <th align="center">Website</th>
      <th align="center">Total Impression</th>
      <th align="center">Total Click</th>
      <th align="center">Publisher Receive</th>
      <th align="center">Advertiser Paid</th>
    </tr>
  </thead>

  <tbody>
    @if (!empty($data) && count($data))
      @foreach ($data as $k => $item)
        <tr valign="middle" height="18">
          <td>({{$item['campaign_id']}}) {{$item['campaign_name']}}</td>
          <td>({{$item['website_id']}}) {{$item['website_name']}}</td>
          <td align="right">{{ number_format($item['total_impression'] + $item['total_impression_ovr']) }} @if(!empty($item['total_impression_ovr']))({{number_format($item['total_impression_ovr'])}})@endif</td> 
          <td align="right">{{ number_format($item['total_click'] + $item['total_click_ovr'])}} @if(!empty($item['total_click_ovr']))({{number_format($item['total_click_ovr'])}})@endif</td>
          <td>{{ $item['publisher_receive'] }}</td>  
          <td>{{ $item['advertiser_paid'] }}</td>  
        </tr>
      @endforeach
    @else
      <tr valign="middle" height="20">
        <td class="no-data" colspan="6">{{trans("text.no_data")}}</td>
      </tr>
    @endif
  </tbody>
</table>