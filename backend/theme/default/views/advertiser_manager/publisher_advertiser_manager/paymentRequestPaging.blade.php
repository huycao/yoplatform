<style>
	.pagination{margin:0 5px 0 0}
	.form-horizontal{display:none}
</style>
<div class="box box-body">
	<table class="table table-striped table-hover table-condensed ">
		<thead>
		<tr>
			<th></th>
			<th>Month</th>
			<th style="text-align: center">Amount (VND)</th>
			<th style="text-align: center">Status</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		@if( count($items)>0)
			@foreach( $items as $item )
				<tr class="item">
					<td width="30">
						@if($item->status=='waiting')
							@if(checkSendRequest())
								<input class="request-item" type="checkbox" value="{{$item->id}}" name="request"/>
							@else
								{{--<input class="request-item" type="checkbox" value="{{$item->id}}" name="request" disabled/>--}}
							@endif
						@else
							<input class="request-item" type="checkbox" value="{{$item->id}}" name="request" disabled/>
						@endif
					</td>
					<td>{{date('Y-m',strtotime($item->created_at))}}</td>
					<td align="right">{{number_format($item->amount)}}</td>
					<td>
						<?php
							switch($item->status){
								case STATUS_REQUEST:
									echo '<label class="label label-warning">'.$item->status.'</label>';break;
								case STATUS_WAITING:
									echo '<label class="label label-info">'.$item->status.'</label>';break;
								case STATUS_DECLINE:
									echo '<label class="label label-default">'.$item->status.'</label>';break;
								case STATUS_APPROVE:
									echo '<label class="label label-success">'.$item->status.'</label>';break;
							}
						?>
					</td>
					<td>
						@if($item->amount>0)
							<a href="/control-panel/publisher/tools/payment-request-detail/{{$item->id}}">Detail</a> |
							<a href="/control-panel/publisher/tools/export/{{$item->id}}">Export</a>
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
<div style="margin:10px 0"><?php echo $items->links(); ?></div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.table tr').click(function(event) {
			var disallow = { "A":1, "IMG":1, "INPUT":1 };
			if(!disallow[event.target.tagName]) {
				$(':checkbox', this).trigger('click');
			}
		});

		$("#request-btn").click(function(){
			var req_items = [];
			$("input[name='request']:checked").each(function (){
				req_items.push($(this).val());
			});
			if(req_items.length >0){
				$.ajax({
					type:'post',
					url:'{{URL::route('ToolsPublisherSendRequestPayment')}}',
					data: {'ids':req_items},
					dataType:'json',
					success: function(result){
						if(result.status == 'ok'){
							$(".alert").hide();
							window.location.reload();
							alert('Đã thực thi thành công!');
						}else{
							$(".alert").hide();
							$(".request-fail").show();
						}
					}
				})
			}else{
				$(".alert").hide();
				$(".non-month").show();
			}
		})
	})
</script>