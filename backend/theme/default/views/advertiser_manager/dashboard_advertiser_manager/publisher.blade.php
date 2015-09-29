<ul id="myTabs" class="nav nav-tabs" style="margin-bottom: 10px">
    <li role="presentation" ><a href="{{ URL::Route($moduleRoutePrefix.'ShowIndex') }}" id="home-tab">Campaign</a></li>
    <li role="presentation" class="active"><a href=""  id="profile-tab" >Publisher</a></li>
</ul>
<div class="row mb12">

    <div class="col-md-12">
        <form class="form-inline" action="" method="POST">
            <div class="form-group">
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control" name="start_date" value="{{ $start_date}}"
                           id="start_date">
                    <span class="input-group-addon">to</span>
                    <input type="text" class="form-control" name="end_date" value="{{ $end_date}}"
                           id="end_date">
                </div>
            </div>
            <div class="form-group">
                <select name="website" class="form-control">
                    <option value="" selected="selected">Select Webiste</option>
                    @foreach($lists_website as $w)
                        @if($w->id == $website)
                            <option value="{{$w->id}}" selected="selected">{{$w->name}}</option>
                        @else
                            <option value="{{$w->id}}">{{$w->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <select name="adformat" class="form-control">
                    <option value="" selected="selected">Select Ad Format</option>
                    @foreach($lists_adfortmat as $af)
                        @if($af->id == $adformat)
                            <option value="{{$af->id}}" selected="selected">{{$af->name}}</option>
                        @else
                            <option value="{{$af->id}}">{{$af->name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Show">
            </div>

        </form>
    </div>
</div>
 
<table class="table table-striped table-hover table-condensed">
    <thead>
    <tr>
        <th align="center" style="text-align: center">Website</th>
        <th>Ad Zone</th>
        <th>Ad format</th>
        <th width="10%" style="text-align: right">Ads success</th>
        <th width="10%" style="text-align: right">Total Ads</th>
    </tr>
    </thead>

    <tbody>
    @foreach($data_ok as $site=>$adzones)
        <?php
        $st = 1;
        ?>
        @foreach($adzones as $az=>$adzone)
            @if(isset($list_site[$site]))
                @if(isset($list_zone[$az]))
                    <tr>
                        @if($st==1)
                            <td rowspan="{{count($adzones)}}" style="vertical-align: middle;text-align: center;">
                                <a href="{{ URL::Route('PublisherAdvertiserManagerShowViewSite', [$list_site[$site]->publisher_id, $list_site[$site]->id ] ) }}">{{ $list_site[$site]->name }}</a>
                            </td>
                        @endif
                        <?php $st++;?>
                        <td><a href="{{URL::Route('PublisherAdvertiserManagerShowUpdateZone', [$list_site[$site]->publisher_id, $list_site[$site]->id,$az])}}"><span class="badge badge-info">{{ $list_zone[$az]->name }}</span></a></td>
                        <td><span class="badge badge-info">{{ $list_zone[$az]->ad_format->name }}</span></td>

                        <td align="right"><span class="badge badge-info">
                                @if(isset($adzone['ads']))
                                    {{ number_format(array_sum($adzone['ads']))}}
                                @else
                                    0
                                @endif
                            </span></td>
                        <td  align="right"><span class="badge badge-info">
                            <?php $total = 0;?>
                                @if(isset($adzone['ads']))
                                     <?php $total  += array_sum($adzone['ads']);?>
                                @endif
                                @if(isset($adzone['noads']))
                                     <?php $total  += array_sum($adzone['noads']);?>
                                @endif
                                {{ number_format($total)}}
                            </span></td>
                    </tr>
                @endif
            @endif
        @endforeach

    @endforeach

    </tbody>

</table>
<script>
    $(function () {

        $('.input-daterange').datepicker({
            todayBtn: "linked"
        });
    });
</script>