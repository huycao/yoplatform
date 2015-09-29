<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box">
	<table class="table table-striped table-hover table-condensed">
	    <thead>
			<tr>
				@include('partials.show_field')
			</tr>
	    </thead>

		<tbody>
			<?php if( count($lists) ){ ?>
				<?php foreach( $lists as $item ){ ?>
				<tr>
					<td>{{$item->name}}</td>			
					<td>
						@if( $item->cost_type == 'cpm' )
							{{number_format($item->amount_impression)}}
						@elseif( $item->cost_type == 'cpc' )
							{{number_format($item->amount_click)}}
						@endif
					</td>			
					<td>{{number_format($item->total_impression)}}</td>			
					<td>{{number_format($item->total_unique_impression)}}</td>			
					<td>{{number_format($item->total_click)}}</td>			
					<td>{{$item->frequency}}</td>			
					<td>{{$item->ctr}} %</td>			
					<td>{{number_format($item->ecpm)}}</td>			
				</tr>
				<?php } ?>
			<?php }else{ ?>
				<tr>
					<td class="no-data" >{{trans("text.no_data")}}</td>
				</tr>
			<?php } ?>
		</tbody>

	</table>
</div>

<div class="admin-pagination">
	{{ $lists->links() }}
	<div class="clearfix"></div>
</div>

<script type="text/javascript">
	
	if( $(".no-data").length > 0 ){
		var colspan = $(".tableList th").length;
		$(".no-data").attr("colspan", colspan);
	} 

</script>


