<style>.pagination{margin:0 5px 0 0}
	.form-horizontal{display:none}
</style>
<div class="box box-body">
	<table id="tableList" class="table table-striped table-hover table-condensed ">
		<thead>
		<tr>
			@if(isset($options['field']) && $options['field'] == 'users.username')
				@if(isset($options['order']) && $options['order'] == 'desc')
					<th class="sorting_asc"><a href="javascript:;" onclick="actionSort('users.username','asc')">Publisher</a></th>
				@else
					<th class="sorting_desc"><a href="javascript:;" onclick="actionSort('users.username','desc')">Publisher</a></th>
				@endif
			@else
				<th class="sorting"><a href="javascript:;" onclick="actionSort('users.username','desc')">Publisher</a></th>
			@endif
			@if(isset($options['field']) && $options['field'] == 'payment_request.created_at')
				@if(isset($options['order']) && $options['order'] == 'desc')
					<th class="sorting_asc"><a href="javascript:;" onclick="actionSort('payment_request.created_at','asc')">Month</a></th>
				@else
					<th class="sorting_desc"><a href="javascript:;" onclick="actionSort('payment_request.created_at','desc')">Month</a></th>
				@endif
			@else
				<th class="sorting"><a href="javascript:;" onclick="actionSort('payment_request.created_at','desc')">Month</a></th>
			@endif

			@if(isset($options['field']) && $options['field'] == 'amount')
				@if(isset($options['order']) && $options['order'] == 'desc')
					<th class="sorting_asc"><a href="javascript:;" onclick="actionSort('amount','asc')">Amount (VND)</a></th>
				@else
					<th class="sorting_desc"><a href="javascript:;" onclick="actionSort('amount','desc')">Amount (VND)</a></th>
				@endif
			@else
				<th class="sorting"><a href="javascript:;" onclick="actionSort('amount','desc')">Amount (VND)</a></th>
			@endif
			<th>Status</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@if( count($items)>0)
			@foreach( $items as $item )
				<tr>
					<td>{{$item->username}}</td>
					<td>{{date('Y-m',strtotime($item->created_at))}}</td>
					<td align="right">{{number_format($item->amount)}}</td>
					<td class="status-text">
						<label class="label label-info">{{$item->status}}</label>
						@if($item->status==STATUS_REQUEST)
							<button class="btn-action btn btn-xs btn-success status-text" id="_a_{{$item->id}}" data-status="{{STATUS_APPROVE}}">{{STATUS_APPROVE}}</button>
							<button class="btn-action btn btn-xs btn-danger status-text" id="_d_{{$item->id}}" data-status="{{STATUS_DECLINE}}">{{STATUS_DECLINE}}</button>
							<button class="btn-action btn btn-xs btn-warning status-text" id="_w_{{$item->id}}" data-status="{{STATUS_WAITING}}">{{STATUS_WAITING}}</button>
						@endif
					</td>
					<td>
						@if($item->amount>0)
							<a href="/control-panel/publisher-manager/approve-tools/payment-request-detail/{{$item->id}}">Detail</a> |
							<a href="/control-panel/publisher-manager/approve-tools/export-payment-request/{{$item->id}}">Export</a>
						@endif
					</td>
				</tr>
			@endforeach
		@else
			<tr><td colspan="5">No data</td>
		@endif
		</tbody>
	</table>
</div>
<div style="margin:10px 0">{{$items->appends($options)->links()}}</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.btn-action').click(function(){
			item_id = $(this).attr('id').substring(3);
			status = $(this).attr('data-status');
			$.ajax({
				type:'post',
				url:'{{URL::to(Route($moduleRoutePrefix.'ChangeStatusPaymentRequest'))}}',
				data:{'id':item_id, 'status':status},
				success:function(){
					alert('Đã thực thi thành công!');
					window.location.reload();
				}
			})
		});
	})
</script>