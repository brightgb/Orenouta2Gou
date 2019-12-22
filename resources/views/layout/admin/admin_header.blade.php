<header class="main-header" style="position: fixed; width: 100%; z-index: 9999;">
    <!-- Logo -->
    <a class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <a href="/admin/logout"><i class="fa fa-fw fa-power-off"></i>ログアウト</a>
                </li>
            </ul>
        </div>
    </nav>
</header>