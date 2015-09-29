<div class="row">
    <div class="col-xs-12">
			<div class="wrap-table">
				
			</div>
    </div>
</div>
<script type="text/javascript">
	$().ready(function(){
		pagination.init({
			url : "{{{ $defaultURL }}}get-list",
			defaultField : "{{{ $defaultField }}}",
			defaultOrder : "{{{ $defaultOrder }}}"
		});
	});
</script>