<div class="row">
    <div class="col-md-12">

        <form method="POST" action="{{ URL::route("PublisherAdvertiserManagerReportExport") }}" accept-charset="UTF-8" role="form" id="report_publisher" class="form-horizontal">
            <div class="box mb12">
                <div class="head row-fluid">
                    <div class="col-md-2" style="  padding: 10px 0;">
                        <input type="text" class="form-control input-sm" id="showmonth" name="showmonth" value="<?php echo Input::get("showmonth","")?>" placeholder="Select month">
                    </div>
                    <div class="col-md-1 text-right selectreport">
                            <input class="btn btn-primary" id="show" type="submit" name="submit" value="Show">
                    </div>
                    <div class="col-md-1" style="padding: 0">
                        <input class="btn btn-primary" id="export" type="submit" name="submit" value="Export Excel">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
{{ HTML::script("{$assetURL}js/chosen.jquery.min.js") }}
{{ HTML::style("{$assetURL}css/chosen.min.css") }}
<script>
    $(function () {
        $('#showmonth').datepicker({
        format: "m/yyyy",
                minViewMode: 1
        });

    });
</script>
@if(isset($data))
    <div class="row">
    <div class="col-xs-12">
        <div class="wrap-table">
            <div class="box mb12">
                <table class="table table-striped table-hover table-condensed">
                    <thead>
                    <tr>
                        <th class=""><a href="javascript:;">Sitelist</a></th>
                        <th class="text-right"><a href="javascript:;">Total</a></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $total = 0;
                    ?>
                    @foreach($dataSite as $site=> $itemsite)
                        @if($itemsite > 0)

                            <?php $sumitem = 0;?>
                            <tr>
                                <td  class="brand_r">{{ $site }}</td>
                                @foreach($data as $flight=> $dataflight)
                                    @if(isset($data[$flight]) && isset($data[$flight][$site]))

                                        <?php
                                        $sumitem += (int) $data[$flight][$site];
                                        ?>
                                    @endif
                                @endforeach
                                <?php
                                $total +=$sumitem;
                                ?>
                                <td align="right">{{ number_format($sumitem)." đ" }}</td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td  class="brand_r">Total: </td>
                        <td  class="text-right">{{  number_format($total)." đ"  }}</td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    </div>
@endif