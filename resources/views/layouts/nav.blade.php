<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid">
    <!-- Section de recherche -->
    <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
      <div class="input-group">
        <div class="input-group-prepend">
          <button type="submit" class="btn btn-search pe-1">
            <i class="fa fa-search search-icon"></i>
          </button>
        </div>
        <input type="text" placeholder="Search ..." class="form-control" />
      </div>
    </nav>

    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
      <!-- Recherche pour petit écran -->
      <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
          <i class="fa fa-search"></i>
        </a>
        <ul class="dropdown-menu dropdown-search animated fadeIn">
          <form class="navbar-left navbar-form nav-search">
            <div class="input-group">
              <input type="text" placeholder="Search ..." class="form-control" />
            </div>
          </form>
        </ul>
      </li>

      <li class="nav-item topbar-icon dropdown hidden-caret">
  <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell"></i>
    <span class="notification" id="notification-count">{{ $totalNotifications }}</span>
  </a>
  <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
    <li>
      <div class="dropdown-title">Vous avez {{ $totalNotifications }} nouvelles notifications</div>
    </li>
    <li>
      <div class="notif-scroll scrollbar-outer">
        <div class="notif-center">
          <!-- Lien pour les nouvelles entreprises -->
          <a class="dropdown-item" href="{{ route('notifications.read.type', 'entreprise') }}">
            <div class="notif-icon notif-primary">
              <i class="fa fa-user-plus"></i>
            </div>
            <div class="notif-content">
              <span class="block">{{ $newCompaniesCount }}</span>
              <span class="small text-muted">nouvelles entreprises</span>
            </div>
          </a>
          <!-- Lien pour les nouvelles demandes -->
          <a class="dropdown-item" href="{{ route('notifications.read.type', 'demande') }}">
            <div class="notif-icon notif-success">
              <i class="fa fa-comment"></i>
            </div>
            <div class="notif-content">
              <span class="block">{{ $newDemandsCount }}</span>
              <span class="small text-muted">nouvelles demandes</span>
            </div>
          </a>
        </div>
      </div>
    </li>
  </ul>
</li>

      

      <!-- Dropdown Profil utilisateur -->
      <li class="nav-item topbar-user dropdown hidden-caret">
        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
          <div class="avatar-sm">
            <img src="{{ asset('assets/img/profile.png') }}" alt="..." class="avatar-img rounded-circle" />
          </div>
          <span class="profile-username">
            <span class="op-7">Bonjour,</span>
            <span class="fw-bold">{{ Auth::user()->name }}</span>
          </span>
        </a>
        <ul class="dropdown-menu dropdown-user animated fadeIn">
          <div class="dropdown-user-scroll scrollbar-outer">
            <li>
              <div class="user-box">
                <div class="avatar-lg">
                  <img src="{{ asset('assets/img/profile.png') }}" alt="image profile" class="avatar-img rounded" />
                </div>
                <div class="u-text">
                  <h4>{{ Auth::user()->name }}</h4>
                  <p class="text-muted">{{ Auth::user()->email }}</p>
                  <a href="{{ route('admin.edit', Auth::user()->id) }}" class="btn btn-xs btn-secondary btn-sm">Mon Profil</a>
                </div>
              </div>
            </li>
            <li>
              <div class="dropdown-divider"></div>
              
              <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
   <i class="fas fa-power-off" style="font-size:125%"></i>
   <span class="ms-2">Se déconnecter</span>
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
   @csrf
</form>

            </li>
          </div>
        </ul>
      </li>
    </ul>
  </div>
</nav>
