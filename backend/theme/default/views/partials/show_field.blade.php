<?php if( !empty($showField) ){ ?>
	<?php foreach( $showField as $field =>	$info ){ ?>
			<?php
				$nextOrder = "desc";
				$orderClass = "sorting";
				if( $field == $defaultField ){
					if( $defaultOrder == "desc" ){
						$nextOrder = "asc";
						$orderClass = "sorting_asc";
					}else{
						$orderClass = "sorting_desc";
					}
				}

				$onClick = "";
				if( !isset($info['sortable']) || $info['sortable'] == TRUE ){
					$onClick = 'onclick="pagination.sort(\''.$field.'\',\''.$nextOrder.'\')"';
				}else{
					$orderClass = "";
				}

			?>
			<th class="<?=$orderClass?>"><a href="javascript:;" {{$onClick}} ><?=$info['label']?></a></th>
	<?php } ?>
<?php } ?>