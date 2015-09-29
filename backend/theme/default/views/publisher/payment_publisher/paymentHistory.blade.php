
<div class="row">
    <div class="col-sm-12">
        <div class="part">
            The minimum cash out is <span class="badge">đ 500,000</span> You will be pain within <span class="badge">45</span> days
            after the end of each month of accrued payments. <span class="badge">10%</span> tax included to all earnings.
        </div>
    </div>
</div>
<div class="part">
<form action="{{URL::Route('PaymentPublisherShowList')}}" method="post">
    <div class="row">
        <div class="col-sm-12 mb12">
            <div class="row">
                <div class="col-sm-4">
                    <select name="showmonth" id="" class="form-control" onchange="this.form.submit();">
                        <option value="">Choose...</option>
                        <option value="1" <?php if($showmonth == 1) print 'selected="selected"'?> >Last 1 months</option>
                        <option value="3" <?php if($showmonth == 3) print 'selected="selected"'?>>Last 3 months</option>
                        <option value="6" <?php if($showmonth == 6) print 'selected="selected"'?>>Last 6 months</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <?php
            if (count($item) > 0) {
                ?>
                <table class="table table-striped table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Description</th>
                            <th>Earings (VNĐ)</th>
                            <th>Payment (VNĐ)</th>
                            <th>Balance (VNĐ)</th>
                        </tr>				
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i <= count($item); $i++) { ?>
                            <?php
                            if (count($item[$i]) > 0) {
                                $total = 0;
                                foreach ($item[$i] as $key=>$value) {
                                    $total +=  $value->balance;
                                    ?>
                                    <tr>
                                         <?php if($key == 0) echo '<td rowspan="'.(count($item[$i]) + 1).'">'.date('M Y',  strtotime ($value->created_at)).'</td>';?>
                                        <td><?= $value->campaign->name?></td>
                                        <td><?= $value->earning?></td>
                                        <td><?= $value->payment?></td>
                                        <td></td>
                                    </tr>
                                <?php }?>
                                    <tr> 
                                        <td><strong>Balance at end of <?= date('M Y',  strtotime ($value->created_at))?></strong></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong><?= $total?></strong></td>
                                    </tr>
                            <?php }
                            ?>
                        <?php } ?>
                      
                    </tbody>
                </table>
            <?php } else { ?>
                {{trans('backend::publisher/text.no_data')}}
            <?php } ?>
        </div>
    </div>
</form>
</div>