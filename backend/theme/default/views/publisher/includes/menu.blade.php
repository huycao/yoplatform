<?php

    $menus = App::make("MenuBackendController")->getMenu();

?>

<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        
        <ul class="sidebar-menu">
            <?php 
                $module = Request::segment(2);
            ?>
            @foreach ($menus as $menu)

                @if( empty($menu['children'] ))
                    <li  class="@if( $module == head(explode("/", $menu['slug'])) ){{{"active"}}}@endif" >
                        <?php
                            if( $menu['slug'] != "" ){
                                $pSlug = Config::get('backend.backend_path').$menu['slug'];
                            }else{
                                $pSlug = "javascript:;";
                            }
                        ?>
                        <a href="{{{ $pSlug }}}">
                            <i class="{{{ $menu['icon'] }}}"></i> 
                            <span>{{{ $menu['name'] }}}</span>
                        </a>
                    </li>
                @else
                    <li class="menu-parent treeview active">
                        <a href="javascript:;">
                            <i class="{{{ $menu['icon'] }}}"></i> 
                            <span>{{{ $menu['name'] }}}</span>
                            <i class="fa pull-right fa-angle-down"></i>
                        </a>
                        <ul class="treeview-menu">
                            @foreach ($menu['children'] as $child)
                                <li class="menu-child @if( $module == head(explode("/", $child['slug'])) ){{{"active"}}}@endif">
                                    <a href="{{{ Config::get('backend.backend_path').$child['slug'] }}}">
                                        <i class="{{{ $child['icon'] }}}"></i> {{{ $child['name'] }}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
