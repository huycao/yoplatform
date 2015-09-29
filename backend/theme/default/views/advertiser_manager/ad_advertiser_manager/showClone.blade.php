<div class="row mb12">
    <div class="col-md-12">
        <div class="box">
            <div class="head">Flight Detail</div>
            <form action="" method="post">
                <table class="table table-striped table-hover table-condensed ">
                    <?php
                    $campaign = $data->campaign;
                    $adFormat = $data->adFormat;
                    ?>
                    <tr>
                        <td>Ad</td>
                        <td><input type="text" class="form-control" id="name" value="{{ $data->name }}" name="name"></td>
                    </tr>
                    <tr>
                        <td>Campaign</td>
                        <td>

                            <div class="col-md-4">
                                <input type="hidden" id="campaign_id"
                                       value="{{{ $data->campaign->id or Input::get('campaign_id') }}}" name="campaign_id">
                                <input type="text" class="form-control input-sm" id="campaign"
                                       value="{{{ $data->campaign->name or Input::get('campaign') }}}" name="campaign" readonly>
                            </div>
                            <div class="col-md-3 text-select">
                                <a href="javascript:;" onclick="Select.openModal('campaign')"
                                   class="btn btn-default btn-block btn-sm">{{trans('text.select_campaign')}}</a>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Flight</td>
                        <td>({{ $data->flight->id or '-' }}) {{ $data->flight->name or '-' }}</td>
                    </tr>
                    <tr>
                        <td>Display Date</td>
                        <td>{{ $data->campaign->dateRange or '-' }}</td>
                    </tr>
                    <tr>
                        <td>Ad Type</td>
                        <td>{{ $data->ad_type or '-' }}</td>
                    </tr>
                    <tr>
                        <td>Ad Format</td>
                        <td>{{ $adFormat->name or '-' }}</td>
                    </tr>
                    <tr>
                        <td>Full Dimension</td>
                        <td>{{ $data->dimension or '-' }}</td>
                    </tr>
                    <tr>
                        <td>Wmode</td>
                        <td>{{ $data->wmode or '-' }}</td>
                    </tr>
                    <tr>
                        <td>Destination URL</td>
                        <td>{{ $data->destination_url or '-' }}</td>
                    </tr>
                </table>
                <div class="head">
                    <div class="col-md-12">
                        <div class="tool-cms">
                            <button type="submit" name="save" value="save" class="btn btn-default btn-sm">Save</button>
                            <a href="http://local.yomedia.com/control-panel/advertiser-manager/ad/show-list" class="btn btn-default btn-sm">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="loadSelectModal">
    @include("partials.select")
</div>