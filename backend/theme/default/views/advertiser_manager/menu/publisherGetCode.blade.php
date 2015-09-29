<div class="sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="#"><i class="fa fa-location-arrow"></i> Quick link<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowList')}}">List Publisher</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowCreateSite', $pid)}}">Add Website</a>
                    </li>
                    @if( isset($wid) )
                    <li>
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowCreateZone', [$pid,$wid])}}">Add Zone</a>
                    </li>                    <li>
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowViewSite', [$pid,$wid])}}">Detail Website</a>
                    </li>
                    @endif
                    <li>
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowView', $pid)}}">Detail Publisher</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
