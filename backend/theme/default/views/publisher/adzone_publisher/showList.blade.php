<div class="box">
	<div class="head">Manage Ad Zone</div>
	<div class="wrap-table content"></div>	
</div>

<script type="text/javascript">
    $().ready(function () {
        pagination.init({
            url: "{{{ $defaultURL }}}get-list",
            defaultField: "{{{ $defaultField }}}",
            defaultOrder: "{{{ $defaultOrder }}}"
        });
    });
</script>