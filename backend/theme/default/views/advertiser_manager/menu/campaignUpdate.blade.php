<div class="sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="#"><i class="fa fa-location-arrow"></i> Quick link<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::Route('CampaignAdvertiserManagerShowCreate')}}">New Campaign</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('CampaignAdvertiserManagerShowList')}}">View Campaign</a>
                    </li>
                    @if( isset($item) )
                    <li>
                        <a href="{{URL::Route('FlightAdvertiserManagerShowCreate')}}?campaign_id={{$item->id}}&campaign={{$item->name}}">New Flight</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('CampaignAdvertiserManagerShowView', $item->id)}}">View Detail</a>
                    </li>
                    @endif
                </ul>
            </li>

        </ul>
    </div>
</div>
