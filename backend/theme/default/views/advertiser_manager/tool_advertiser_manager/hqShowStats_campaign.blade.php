<div class="admin-pagination mb12">
  {{ $data->links() }}
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
        <th>Total Impression</th>
        <th>Total Click</th>
        <th>Publisher Receive</th>
        <th>Advertiser Paid</th>
      </tr>
    </thead>

    <tbody>
      <?php $summary = 0; ?>
      <?php
      if (!empty($data) && count($data)) {
        foreach ($data as $k => $item) {
          ?>
          <tr>
            <td>{{$item['campaign_name']}}</td>
            <td>{{ number_format($item['total_impression']) }}</td> 
            <td>{{ number_format($item['total_click'])}}</td>
            <td>{{ number_format($item['publisher_receive']) }} VND</td>  
            <td>{{ number_format($item['advertiser_paid']) }} VND</td>  
          </tr>
          <?php
        }
      } else {
        ?>
        <tr>
          <td class="no-data" colspan="5" >{{trans("text.no_data")}}</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<div class="admin-pagination mb12">
  {{ $data->links() }}
</div>