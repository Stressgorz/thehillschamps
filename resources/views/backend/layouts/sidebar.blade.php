<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
    <div class="sidebar-brand-icon">
    <img src="{{ asset('/images/logo.png') }}" id="slip" alt="..." style = 'max-width:100px;'>
    </div>

  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{route('admin')}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Information
  </div>

  {{-- Admin --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#adminCollapse" aria-expanded="true" aria-controls="adminCollapse">
      <i class="fas fa-truck"></i>
      <span>Admin</span>
    </a>
    <div id="adminCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Admin Options:</h6>
        <a class="collapse-item" href="{{route('admin-setting.index')}}">Admin</a>
        <a class="collapse-item" href="{{route('admin-setting.create')}}">Add Admin</a>
      </div>
    </div>
  </li>

  {{-- IB --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ibCollapse" aria-expanded="true" aria-controls="ibCollapse">
      <i class="fas fa-truck"></i>
      <span>IB</span>
    </a>
    <div id="ibCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">User Options:</h6>
        <a class="collapse-item" href="{{route('users.index')}}">User</a>
        <a class="collapse-item" href="{{route('users.create')}}">Add User</a>
      </div>
    </div>
  </li>

  {{-- Sales --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#salescollapse" aria-expanded="true" aria-controls="salescollapse">
      <i class="fas fa-truck"></i>
      <span>Sales</span>
    </a>
    <div id="salescollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Sales Options:</h6>
        <a class="collapse-item" href="{{route('sales-admin.index')}}">Sales</a>
      </div>
    </div>
  </li>

  {{-- Client --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#clientcollapse" aria-expanded="true" aria-controls="clientcollapse">
      <i class="fas fa-truck"></i>
      <span>Client</span>
    </a>
    <div id="clientcollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Client Options:</h6>
        <a class="collapse-item" href="{{route('clients-admin.index')}}">Client</a>
      </div>
    </div>
  </li>


  {{-- Admin Kpi --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#adminkpicollpase" aria-expanded="true" aria-controls="adminkpicollpase">
      <i class="fas fa-truck"></i>
      <span>Kpi</span>
    </a>
    <div id="adminkpicollpase" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Kpi Options:</h6>
        <a class="collapse-item" href="{{route('admin-kpi.index')}}">Kpi</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Management
  </div>

  {{-- Team --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#teamCollapse" aria-expanded="true" aria-controls="teamCollapse">
      <i class="fas fa-truck"></i>
      <span>Team</span>
    </a>
    <div id="teamCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Team Options:</h6>
        <a class="collapse-item" href="{{route('teams.index')}}">Team</a>
        <a class="collapse-item" href="{{route('teams.create')}}">Add Team</a>
      </div>
    </div>
  </li>

  {{-- Position --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#positionCollapse" aria-expanded="true" aria-controls="positionCollapse">
      <i class="fas fa-truck"></i>
      <span>Position</span>
    </a>
    <div id="positionCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Position Options:</h6>
        <a class="collapse-item" href="{{route('positions.index')}}">Position</a>
      </div>
    </div>
  </li>

  {{-- Announcement --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#annoucementCollapse" aria-expanded="true" aria-controls="annoucementCollapse">
      <i class="fas fa-truck"></i>
      <span>Announcement</span>
    </a>
    <div id="annoucementCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Announcement Options:</h6>
        <a class="collapse-item" href="{{route('announcements.index')}}">Announcement</a>
        <a class="collapse-item" href="{{route('announcements.create')}}">Add Announcement</a>
      </div>
    </div>
  </li>

  {{-- Calendar --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#calendarCollapse" aria-expanded="true" aria-controls="calendarCollapse">
      <i class="fas fa-truck"></i>
      <span>Calendar</span>
    </a>
    <div id="calendarCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Calendar Options:</h6>
        <a class="collapse-item" href="{{route('calendars.index')}}">Calendar</a>
        <a class="collapse-item" href="{{route('calendars.create')}}">Add Calendar</a>
      </div>
    </div>
  </li>

  {{-- kpi --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kpiCollapse" aria-expanded="true" aria-controls="kpiCollapse">
      <i class="fas fa-truck"></i>
      <span>Kpi Question</span>
    </a>
    <div id="kpiCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Kpi Options:</h6>
        <a class="collapse-item" href="{{route('kpi-question.index')}}">Kpi Question</a>
        <a class="collapse-item" href="{{route('kpi-question.create')}}">Add Kpi Question</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Approval
  </div>

  {{-- Sales Approval --}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#salesapprovalcollapse" aria-expanded="true" aria-controls="salesapprovalcollapse">
      <i class="fas fa-truck"></i>
      <span>Sales Approval</span>
    </a>
    <div id="salesapprovalcollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Sales Approval Options:</h6>
        <a class="collapse-item" href="{{route('sales-approval.index')}}">Sales Approval</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  <!-- Heading -->
  <div class="sidebar-heading">
    Leaderboard Settings
  </div>
  <!-- General settings -->


  <!--Leaderboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin-get-leaderboard-sale', 'user')}}">
      <i class="fas fa-hammer fa-chart-area"></i>
      <span>Leaderboard (Sales)</span>
    </a>
  </li>

  <!--Leaderboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin-get-leaderboard-client', 'user')}}">
      <i class="fas fa-hammer fa-chart-area"></i>
      <span>Leaderboard (Client)</span>
    </a>
  </li>

  <!--Leaderboard -->
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin-get-leaderboard-ib', 'user')}}">
      <i class="fas fa-hammer fa-chart-area"></i>
      <span>Leaderboard (Ib)</span>
    </a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">


  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>