<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style = 'background-color:#163255'>

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user')}}">
      <div class="sidebar-brand-text mx-3">Welcome {{Auth()->user()->firstname.' '.Auth()->user()->lastname}}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
      <a class="nav-link" href="{{route('user')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Profile</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clientCollapse" aria-expanded="true" aria-controls="clientCollapse">
          <i class="fas fa-truck"></i>
          <span>Client</span>
        </a>
        <div id="clientCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Client Options:</h6>
            <a class="collapse-item" href="{{route('clients.index')}}">Clients</a>
            <a class="collapse-item" href="{{route('clients.create')}}">Add Client</a>
          </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#saleCollapse" aria-expanded="true" aria-controls="saleCollapse">
          <i class="fas fa-truck"></i>
          <span>Sales</span>
        </a>
        <div id="saleCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Sales Options:</h6>
            <a class="collapse-item" href="{{route('sales.index')}}">Sales</a>
            <a class="collapse-item" href="{{route('sales.create')}}">Add Sale</a>
          </div>
        </div>
    </li>

    <!--Leaderboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('get-leaderboard-sale', 'user')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Leaderboard (Sales)</span>
        </a>
    </li>

        <!--Leaderboard -->
        <li class="nav-item">
        <a class="nav-link" href="{{route('get-leaderboard-client', 'user')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Leaderboard (Client)</span>
        </a>
    </li>

        <!--Leaderboard -->
        <li class="nav-item">
        <a class="nav-link" href="{{route('get-leaderboard-ib', 'user')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Leaderboard (Ib)</span>
        </a>
    </li>

    @if(Auth::user()->position->name != 'Director' && Auth::user()->position->name != 'Marketer')
    <!--Road Map Points -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('road-map-points')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Road Map Points</span>
        </a>
    </li>
    @endif

        <!--Road Map Points -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('announcement-data')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Announcement</span>
        </a>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>