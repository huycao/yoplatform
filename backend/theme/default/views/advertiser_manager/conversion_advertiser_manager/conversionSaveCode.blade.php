<script type="text/javascript">
	var _avlParam = {};
@if(!empty($data->param))
	<?php 
	    $index = 0;
	    $lenParam = count($data->param);
	?>
_avlParam = {
@foreach ($data->param as $param)
	<?php
	    $index++;
	    $comma = '';
	    if ($index < $lenParam) {
	        $comma = ',';   
	    }
    ?>
	'{{$param}}': '[{{$param}}]'{{$comma}}
@endforeach
	};
@endif
	var _conversionID = '{{$data->id}}';
</script>
<script "text/javascript" src="http://delivery.yomedia.vn/public/source/yo-conversion.js"></script>  