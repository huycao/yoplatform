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
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowCreateSite', Request::segment(4))}}">Add Website</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('PublisherAdvertiserManagerShowListSite', Request::segment(4))}}">List Website</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
