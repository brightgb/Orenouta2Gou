<aside class="main-sidebar" style="position: fixed;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" style="cursor: pointer;">
            @foreach(config('adminlte.menu', []) as $item)
                {{-- サブメニュー --}}
                @if (!empty($item['sub_menu']))
                    <li class="treeview" id="{{ $item['menu_id'] }}" style="font-weight: normal !important;">
                        <a>
                            <i class="fa fa-fw fa-{{ $item['icon'] }}"></i>
                            <span style="margin-left: 1em;">{{ $item['text'] }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            @foreach ($item['sub_menu'] as $sub_item)
                            <li id="{{ $sub_item['menu_id'] }}" style="vertical-align: middle; font-weight: normal !important;" class="active">
                                <a href="{{ url($sub_item['url']) }}" style="padding: 10px 5px 10px 3em;">
                                    <i class="fa fa-fw fa-{{ $sub_item['icon'] }}"></i>
                                    <span style="margin-left: 1em;">{{ $sub_item['text'] }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                {{-- 通常メニュー --}}
                @else
                    <li id="{{ $item['menu_id'] }}" style="font-weight: normal !important;">
                        <a href="{{ url($item['url']) }}">
                            <i class="fa fa-fw fa-{{ $item['icon'] }}"></i>
                            <span style="margin-left: 1em;">{{ $item['text'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>