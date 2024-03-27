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
    @if(Auth::user()->position->name != 'Marketer')
    <!--Leaderboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user-point-history')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Point History</span>
        </a>
    </li>
    @endif
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
    @if(Auth::user()->id == 1000000)
    @if(Auth::user()->position->name == 'IB')
    <!--KPI -->
    <li class="nav-item">
      <a class="nav-link" href="https://forms.gle/hiBnxSw9Kw1RBe2bA">
          <i class="fas fa-hammer fa-chart-area"></i>
          <span>KPI</span>
      </a>
    </li>
    @elseif(Auth::user()->position->name == 'Senior')
    <li class="nav-item">
      <a class="nav-link" href="https://forms.gle/NeEYaE5PRNXst8hj6">
          <i class="fas fa-hammer fa-chart-area"></i>
          <span>KPI</span>
      </a>
    </li>
    @elseif(Auth::user()->position->name == 'Leader')
    <li class="nav-item">
      <a class="nav-link" href="https://forms.gle/8FQ39QcZQNihTb559">
          <i class="fas fa-hammer fa-chart-area"></i>
          <span>KPI</span>
      </a>
    </li>
    @elseif(Auth::user()->position->name == 'Director')
    <li class="nav-item">
      <a class="nav-link" href="https://forms.gle/6azKWgfaaQdLfjFt9">
          <i class="fas fa-hammer fa-chart-area"></i>
          <span>KPI</span>
      </a>
    </li>
    @endif
    @endif
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userkpiCollapse" aria-expanded="true" aria-controls="userkpiCollapse">
          <i class="fas fa-truck"></i>
          <span>User Kpi</span>
        </a>
        <div id="userkpiCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">User Kpi Options:</h6>
            <a class="collapse-item" href="{{route('user-kpi.index')}}">Kpi</a>
            <a class="collapse-item" href="{{route('user-kpi.create')}}">Add Kpi</a>
          </div>
        </div>
    </li>

    
    @if(Auth::user()->position->name != 'Marketer')
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
    @endif
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