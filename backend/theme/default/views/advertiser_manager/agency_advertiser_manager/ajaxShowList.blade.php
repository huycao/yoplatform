<div class="admin-pagination">
	{{$lists->links()}}
	<div class="clearfix"></div>
</div>
<div class="box">
<table class="table table-striped table-hover table-condensed has-child">
    <thead>
		<tr>
			@include('partials.show_field')
			<th><a href="javascript:;">Action</a></th>
		</tr>
    </thead>

	<tbody>
		<?php if( count($lists) ){ 
			$stt = ($lists->getCurrentPage()-1) * $lists->getPerPage() ; 
		?>
			<?php foreach( $lists as $item ){ ?>
			<tr>
				<?php 
					if( !empty($showField) ){ 
						foreach( $showField as $field =>	$info ){
							$value = ( isset($info['alias']) ) ? $item->{$info['alias']} : $item->{$field};
							echo AdminGetTypeContent::make($info['type'], $field, $item->id, $value);
						} 
					} 
				?>
				<td>
					<a href="{{ URL::Route($moduleRoutePrefix.'ShowUpdate',$item['id']) }}" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-pencil"></span> Edit
					</a>
					<a href="javascript:;" onclick="deleteItem({{{$item->id}}})" class="btn btn-default btn-sm">
						<span class="fa fa-trash-o"></span> Del
					</a>
					<a href="javascript:;" onclick="toggleContact({{$item->id}})" class="btn btn-default btn-sm">
						<span class="fa fa-eye"></span> Show Contact
					</a>
				</td>				
			</tr>
			<tr class="toggle toggle-{{$item->id}}">
				<td colspan="5">
				<table class="table table-responsive table-striped table-hover table-condensed table-bordered tableList">
				    <thead>
						<tr class="bg-default">
					            <th>Name</th>
					            <th>Email</th>
					            <th>Phone</th>
					            <th>Fax</th>
					        </tr>
					    </thead>
					    <tbody>
							
					        @if( ($item->contact) )
					            @foreach( $item->contact as $contact )
					                <tr>
					                    <td>{{$contact->name}}</td>
					                    <td>{{$contact->email}}</td>
					                    <td>{{$contact->phone}}</td>
					                    <td>{{$contact->fax}}</td>
					                </tr>
					            @endforeach
					        @endif

					    </tbody>
					</table>					
				</td>
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


