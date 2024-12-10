<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela! {{
                    Auth::user()->type }}</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ Auth::user()->name }}</h2>
                <span>{{ Auth::user()->email }}</span>
            </div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    @forelse (leftMenu() as $level1)
                    @isset($level1['submenu'])

                    
                    <li><a><i class="fa fa-{{ $level1['icon'] ?? 'list-ul' }}"></i> {{ $level1['text'] ?? 'No Menu
                            Text' }} <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            @forelse ($level1['submenu'] as $level2)
                                @isset($level2['can'])
                                    @foreach ($level2['can'] as $item)

                                    @php
                                    if($item == Auth::user()->type){
                                    $showMenu = true;
                                    }
                                    @endphp

                                    @endforeach

                                    @else

                                    @php
                                    $showMenu = true;
                                    @endphp

                                @endisset
                                
                                    @isset ($showMenu)
                                        <li>
                                            <a href="{{ $level2['url'] ?? '#' }}">{{ $level2['text'] ?? 'No menu text' }}</a>
                                        </li>
                                    @endisset
                            @empty
                            @endforelse
                        </ul>
                    </li>


                    @else
                    <li><a href="{{ $level1['url'] ?? '#' }}"><i class="fa fa-{{ $level1['icon'] ?? 'list-ul' }}"></i>
                            {{ $level1['text'] ?? 'No menu text' }}
                        </a>
                    </li>
                    @endisset
                    @empty
                    Faka ken mama
                    @endforelse
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
