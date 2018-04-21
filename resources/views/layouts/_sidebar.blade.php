<ul id="side-nav" class="main-menu navbar-collapse collapse">
    @foreach ($menus as $label => $menu)
        @if (is_array($menu['url']))
        <li class="has-sub"><a href="#"><i class="fa fa-{{$menu['icon']}}"></i><span class="title">{{$label}}</span></a>
            <ul class="nav collapse">
                @foreach ($menu['url'] as $subroute => $sublabel)
                    @if (is_array($sublabel))
                        <li class="has-sub"><a href="#"><span class="title">{!!$subroute!!}</span></a>
                        <ul class="nav collapse">
                        @foreach($sublabel as $subsubroute => $subsublabel)
                            <li class="{{url()->current() == url($subsubroute) ? 'active' : ''}}"><a href="{{url($subsubroute)}}"><span class="title">{!!$subsublabel!!}</span></a></li>
                        @endforeach
                        </ul>
                    @else
                        <li class="{{url()->current() == url($subroute) ? 'active' : ''}}"><a href="{{url($subroute)}}"><span class="title">{!!$sublabel!!}</span></a></li>
                    @endif
                @endforeach
            </ul>
        </li>
        @else
        <li><a href="{{url($menu['url'])}}"><i class="fa fa-{{$menu['icon']}}"></i><span class="title">{{$label}}</span></a></li>
        @endif
    @endforeach
</ul>
