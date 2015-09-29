<div class="sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="active">
                <a href="#"><i class="fa fa-location-arrow"></i> Quick link<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{URL::Route('AdAdvertiserManagerShowCreate')}}">New Ad</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('AdAdvertiserManagerShowUpdate',Request::segment(5))}}">Edit Ad</a>
                    </li>
                    <li>
                        <a href="{{URL::Route('AdAdvertiserManagerShowList')}}">Ad</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
