<div class="admin-pagination mb12">
  {{ $paging->links() }}
</div>
<div class="box mb12">
  <table class="table table-striped table-hover table-condensed">
    <colgroup>
      <col >
      <col >
      <col >
      <col >
    </colgroup>
    <thead>
      <tr>
        <th>Campaign</th>
        <th>Website</th>
        <th>Total Impression</th>
        <th>Total Click</th>
        <th>Publisher Receive</th>
        <th>Advertiser Paid</th>
      </tr>
    </thead>

    <tbody>
      @if (!empty($data) && count($data))
        @foreach ($data as $k => $item)
          <tr>
            <td>({{$item['campaign_id']}}) {{$item['campaign_name']}}</td>
            <td>({{$item['website_id']}}) {{$item['website_name']}}</td>
            <td>
              {{ number_format($item['total_impression'] + $item['total_impression_ovr']) }}
              @if(!empty($item['total_impression_ovr']))
                  <span style="color: blue;">({{number_format($item['total_impression_ovr'])}})</span>
              @endif
            </td> 
            <td>
              {{ number_format($item['total_click'] + $item['total_click_ovr'])}}
              @if(!empty($item['total_click_ovr']))
                  <span style="color: blue;">({{number_format($item['total_click_ovr'])}})</span>
              @endif
            </td>
            <td>{{ number_format($item['publisher_receive']) }} VND</td>  
            <td>{{ number_format($item['advertiser_paid']) }} VND</td>  
          </tr>
        @endforeach
      @else
        <tr>
          <td class="no-data" colspan="7" >{{trans("text.no_data")}}</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>
<div class="admin-pagination mb12">
  {{ $paging->links() }}
</div>