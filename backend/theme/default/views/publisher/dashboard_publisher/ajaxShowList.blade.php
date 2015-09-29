 
<table id="tableList" class="table table-responsive">

    <thead>
        <tr>			
            <th>#</th>
            <th>{{trans("backend::publisher/text.site")}}</th>								
            <th>{{trans("backend::publisher/text.impressions")}}</th>
            <th>{{trans("backend::publisher/text.engagements")}}</th>
            <th>{{trans("backend::publisher/text.clicks")}}</th>
            <th>{{trans("backend::publisher/text.ctr")}}</th>
            <th style="text-align: right">{{trans("backend::publisher/text.earnings")}} (<ins>đ</ins>)</th>			
        </tr>
    </thead>

    <tbody>
        <?php
        if (count($lists)) {
            $stt = 0;
            ?>
            <?php
            foreach ($lists as $item) {
                $stt++;
                ?>
                <tr>
                    <td><?= $stt; ?></td>                                         
                    <td><?= $item->site; ?></td>                                         
                    <td ><?= numberVN($item->impressions); ?></td>                                         
                    <td ><?= $item->engagements; ?></td>                                         
                    <td ><?= $item->clicks; ?></td>                                         
                    <td ><?= $item->ctr . " % "; ?></td>                                         
                    <td align="right" ><?= numberVN($item->earnings, 2); ?> (<ins>đ</ins>)</td>           
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td class="no-data" >{{trans("backend::publisher/text.no_data")}}</td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="2">{{trans("backend::publisher/text.total")}}</td>
                <td ><?= numberVN($total->impressions)?></td> 
                <td ><?=$total->engagements?></td> 
                <td ><?=$total->clicks?></td> 
                <td ><?=$total->ctr . " % "?></td> 
                <td align="right" ><?= numberVN($total->earnings) ?> (<ins>đ</ins>)</td>  
            </tr>
    </tbody>

</table> 

<script type="text/javascript">
    
 
    if ($(".no-data").length > 0) {
        var colspan = $("#tableList th").length;
        $(".no-data").attr("colspan", colspan);
    }
    
     
</script>


