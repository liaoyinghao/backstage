<div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu @if(request()->cookie('manage_side')) page-sidebar-menu-closed @endif" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        @foreach($left_menu as $parentk => $parent)
        <li class="nav-item @if($parentk == $view_path[1]) active open @endif">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="{{$parent['icon']}}"></i>
                <span class="title">{{$parent['name']}}</span>
                @if($parentk == $view_path[1])
                <span class="selected"></span>
                <span class="arrow open"></span>
                @endif
            </a>

            <ul class="sub-menu">
                @foreach($parent['son'] as $sonk => $son)
                <li class="nav-item  @if($son['url'] == $view_path[2] && $parentk == $view_path[1]) active open @endif">
                    <a href="{{route('manage_'. $parentk .'_'. $son['url'])}}" class="nav-link ">
                        <span class="title">{{$son['name']}}</span>
                        @if($sonk == $view_path[2] && $parentk == $view_path[1])
                        <span class="selected"></span>
                        @endif
                    </a>
                </li>
                 @endforeach
            </ul>

        </li>
        @endforeach
    </ul>
</div>
