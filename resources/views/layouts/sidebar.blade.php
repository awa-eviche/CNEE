<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="{{ asset('assets/img/kaiadmin/logo_light.svg')}}"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
              <a href="{{ route('dashboard') }}" class="collapsed">
    <i class="fas fa-home"></i>
    <p>Tableau de Bord</p>
</a>

                <div class="collapse" id="dashboard">
                
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Components</h4>
              </li>
              @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
              <li class="nav-item">
                <a  href="{{ route('admin.index') }}">
                  <i class="fas fa-layer-group"></i>
                  <p>Gestion Utilisateur</p>
                 
                </a>
                <div class="collapse" id="base"> 
                </div>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{route('entreprise.index')}}">
                  <i class="fas fa-th-list"></i>
                  <p>Gestion Entreprise</p>
                
                </a>
                <div class="collapse" id="sidebarLayouts">
                  <!--ul class="nav nav-collapse">
                    <li>
                      <a href="sidebar-style-2.html">
                        <span class="sub-item">Sidebar Style 2</span>
                      </a>
                    </li>
                    <li>
                      <a href="icon-menu.html">
                        <span class="sub-item">Icon Menu</span>
                      </a>
                    </li>
                  </ul-->
                </div>
              </li>
           @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
       <li class="nav-item">
  <a data-bs-toggle="collapse" href="#forms" aria-expanded="false">
    <i class="fas fa-pen-square"></i>
    <p>Gestion Demandeur</p>
    <span class="caret"></span>
  </a>
  <div class="collapse" id="forms">
    <ul class="nav nav-collapse">
      <li>
        <a href="{{ route('profil.index') }}">
          <span class="sub-item">Gestion des profils</span>
        </a>
      </li>
      <li>
        <a href="{{ route('niveau.index') }}">
          <span class="sub-item">Gestion des niveaux</span>
        </a>
      </li>
      <li>
        <a href="{{ route('demandeur.index') }}">
          <span class="sub-item">Gestion des demandeurs</span>
        </a>
      </li>

      <li>
        <a href="{{ route('demandeurprofil.index') }}">
          <span class="sub-item">Gestion des profils demandeurs</span>
        </a>
      </li>
    </ul>
  </div>
</li>
@endif
@if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#tables">
                  <i class="fas fa-table"></i>
                  <p>Gestion CNEE</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="tables">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('demande.index') }}">
                        <span class="sub-item">Profils demandes</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{ route('demanderetenu') }}">
                        <span class="sub-item">Profils retenus</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif
              @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#">
                <i class="fas fa-file"></i>
                  <p>Gestion Allocation</p>
                 
                </a>
                <div class="collapse" id="maps">
               
                </div>
              </li>
              @endif
              @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
              <li class="nav-item">
                <a href="{{ route('archive.index') }}">
                <i class="fas fa-file"></i>
                  <p>Gestion archives</p>
                 
                </a>
                <div class="collapse" id="maps">
                </div>
              </li>
              @endif
              @if (auth()->user()->role && auth()->user()->role->name == 'entreprise')
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#maps">
                  <i class="fas fa-table"></i>
                  <p>Gestion des stagiaires</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="maps">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="{{ route('demande.index') }}">
                        <span class="sub-item">Demande de Profils</span>
                      </a>
                    </li>
                  
                  </ul>
                </div>
              </li>
              @endif
              @if (auth()->user()->role && auth()->user()->role->name == 'entreprise')
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#charts">
                  <i class="far fa-chart-bar"></i>
                  <p>Gestion</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="charts">
                  <ul class="nav nav-collapse">
                    <li>
                     
                      <a href="{{ route('demanderecu') }}">
                        <span class="sub-item">Demandeur reçu</span>
                      </a>
                    </li>
                    <li>
                    <a href="charts/charts.html">
                        <span class="sub-item">Demandeur retenu</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif
            </ul>
            
          </div>
          
        </div>
      </div>