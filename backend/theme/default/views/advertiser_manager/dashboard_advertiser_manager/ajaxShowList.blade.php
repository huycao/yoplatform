 
<table id="tableList" class="table table-responsive">

    <thead>
        <tr>			
            <th>#</th>
            <th>{{trans("backend::publisher/text.site")}}</th>								
            <th>{{trans("backend::publisher/text.impressions")}}</th>
            <th>{{trans("backend::publisher/text.engagements")}}</th>
            <th>{{trans("backend::publisher/text.clicks")}}</th>
            <th>{{trans("backend::publisher/text.ctr")}}</th>
            <th>{{trans("backend::publisher/text.earnings")}} (<ins>đ</ins>)</th>			
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
                    <td><?= numberVN($item->impressions); ?></td>                                         
                    <td><?= $item->engagements; ?></td>                                         
                    <td><?= $item->clicks; ?></td>                                         
                    <td><?= $item->ctr . " % "; ?></td>                                         
                    <td><?= numberVN($item->earnings, 2); ?></td>           
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td class="no-data" >{{trans("backend::publisher/text.no_data")}}</td>
            </tr>
        <?php } ?>
            <tr>
                <td colspan="2">{{trans("backend::publisher/text.total")}}</td>
                <td class="totalColumn"></td>
                <td class="totalColumn"></td>
                <td class="totalColumn"></td>
                <td class="totalColumn"></td>
                <td class="totalColumn"></td>
            </tr>
    </tbody>

</table> 

<script type="text/javascript">
$(function(){
   
    if ($(".no-data").length > 0) {
        var colspan = $("#tableList th").length;
        $(".no-data").attr("colspan", colspan);
    }
    
    $('#tableList tr:first td').each(function () {
        var $td = $(this);

        var colTotal = 0;
        $('#tableList tr:not(:first,.totalColumn)').each(function () {
            colTotal += parseInt($(this).children().eq($td.index()).html(), 10);
        });

        $('#tableList tr.totalColumn').children().eq($td.index()).html('Total: ' + colTotal);
    });
 
});
</script>


