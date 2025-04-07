<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="/" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/logocnee.png') }}" alt="navbar brand" class="navbar-brand" height="20"/>
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
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="collapsed">
                        <i class="fas fa-home"></i>
                        <p>Tableau de Bord</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>

                @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
                <li class="nav-item {{ request()->is('admin*') ? 'active' : '' }}">
                    <a href="{{ route('admin.index') }}">
                        <i class="fas fa-layer-group"></i>
                        <p>Gestion Utilisateur</p>
                    </a>
                </li>
                @endif

                <li class="nav-item {{ request()->is('entreprise*') ? 'active' : '' }}">
                    <a href="{{ route('entreprise.index') }}">
                        <i class="fas fa-th-list"></i>
                        <p>Gestion Entreprise</p>
                    </a>
                </li>

                @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
<li class="nav-item">
    <a class="menu-toggle" data-bs-toggle="collapse" href="#forms" aria-expanded="{{ request()->is('profil*') || request()->is('niveau*') || request()->is('demandeur*') || request()->is('demandeurprofil*') ? 'true' : 'false' }}">
        <i class="fas fa-pen-square"></i>
        <p>Gestion Demandeur</p>
        <span class="caret"></span>
    </a>
    <div class="collapse {{ request()->is('profil*') || request()->is('niveau*') || request()->is('demandeur*') || request()->is('demandeurprofil*') ? 'show' : '' }}" id="forms">
        <ul class="nav nav-collapse">
            <li><a href="{{ route('profil.index') }}" class="{{ request()->is('profil*') ? 'active' : '' }}"><span class="sub-item">Gestion des profils</span></a></li>
            <li><a href="{{ route('niveau.index') }}" class="{{ request()->is('niveau*') ? 'active' : '' }}"><span class="sub-item">Gestion des niveaux</span></a></li>
            <li><a href="{{ route('demandeur.index') }}" class="{{ request()->is('demandeur*') ? 'active' : '' }}"><span class="sub-item">Gestion des demandeurs</span></a></li>
            <li><a href="{{ route('demandeurprofil.index') }}" class="{{ request()->is('demandeurprofil*') ? 'active' : '' }}"><span class="sub-item">Gestion des profils demandeurs</span></a></li>
        </ul>
    </div>
</li>
@endif

@if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
<li class="nav-item">
    <a class="menu-toggle" data-bs-toggle="collapse" href="#tables" aria-expanded="{{ request()->is('demande*') ? 'true' : 'false' }}">
        <i class="fas fa-table"></i>
        <p>Gestion demandes</p>
        <span class="caret"></span>
    </a>
    <div class="collapse {{ request()->is('demande*') ? 'show' : '' }}" id="tables">
        <ul class="nav nav-collapse">
            <li><a href="{{ route('demande.index') }}" class="{{ request()->is('demande*') ? 'active' : '' }}"><span class="sub-item">Profils demandes</span></a></li>
            <li><a href="{{ route('demanderetenu') }}" class="{{ request()->is('demanderetenu') ? 'active' : '' }}"><span class="sub-item">Profils retenus</span></a></li>
        </ul>
    </div>
</li>
@endif


                @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
                <li class="nav-item">
                    <a class="menu-toggle" data-bs-toggle="collapse" href="#allocation" aria-expanded="{{ request()->is('secteur*') || request()->is('classification*') || request()->is('allocation*') ? 'true' : 'false' }}">
                        <i class="fas fa-file"></i>
                        <p>Gestion Allocation</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('secteur*') || request()->is('classification*') || request()->is('allocation*') ? 'show' : '' }}" id="allocation">
                        <ul class="nav nav-collapse">
                            <li><a href="{{ route('secteur.index') }}" class="{{ request()->is('secteur*') ? 'active' : '' }}"><span class="sub-item">Gestion secteur</span></a></li>
                            <li><a href="{{ route('classification.index') }}" class="{{ request()->is('classification*') ? 'active' : '' }}"><span class="sub-item">Gestion classification</span></a></li>
                            <li><a href="{{ route('allocation.index') }}" class="{{ request()->is('allocation*') ? 'active' : '' }}"><span class="sub-item">Gestion de la paie</span></a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
                <li class="nav-item">
                  
            <a class="menu-toggle" data-bs-toggle="collapse" href="#charts"  aria-expanded="{{ request()->is('archive*') || request()->is('archivrej*') || request()->is('archive*') ? 'true' : 'false' }}">
        <i class="fas fa-file"></i>
        <p>Gestion Archives</p>
        <span class="caret"></span>
         </a>
         <div class="collapse {{ request()->is('archive*') || request()->is('archiverej*')  ? 'show' : '' }}"id="charts">
        <ul class="nav nav-collapse">
            <li><a href="{{ route('archive.index') }}" class="{{ request()->is('archive*') ? 'active' : '' }}"><span class="sub-item">Archives validés</span></a></li>
            <li><a href="{{ route('archiverej.index') }}" class="{{ request()->is('archiverej') ? 'active' : '' }}"><span class="sub-item">Archives rejetés</span></a></li>
        </ul>
    </div>
                </li>
                @endif

                @if (auth()->user()->role && auth()->user()->role->name == 'entreprise')
                <li class="nav-item">
                    <a class="menu-toggle" data-bs-toggle="collapse" href="#profils" aria-expanded="{{ request()->is('demande*') ? 'true' : 'false' }}">
                        <i class="fas fa-table"></i>
                        <p>Profils recherchés</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('demande*') ? 'show' : '' }}" id="profils">
                        <ul class="nav nav-collapse">
                            <li><a href="{{ route('demande.index') }}" class="{{ request()->is('demande*') ? 'active' : '' }}"><span class="sub-item">Demande de Profils</span></a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @if (auth()->user()->role && auth()->user()->role->name == 'entreprise')
                <li class="nav-item">
                    <a class="menu-toggle" data-bs-toggle="collapse" href="#gestion-demandes" aria-expanded="{{ request()->is('demanderetenu') ? 'true' : 'false' }}">
                        <i class="far fa-chart-bar"></i>
                        <p>Gestion demandes</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('demanderetenu') ? 'show' : '' }}" id="gestion-demandes">
                        <ul class="nav nav-collapse">
                            <li><a href="{{ route('demanderetenu') }}" class="{{ request()->is('demanderetenu') ? 'active' : '' }}"><span class="sub-item">Demandeur retenu</span></a></li>
                        </ul>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- Script JavaScript pour gérer l'ouverture et la fermeture des menus -->
<script>
    document.querySelectorAll('.menu-toggle').forEach(item => {
        item.addEventListener('click', function() {
            const target = this.getAttribute('href');
            const collapseElement = document.querySelector(target);
            const isOpen = collapseElement.classList.contains('show');

            // Fermer tous les autres menus
            document.querySelectorAll('.collapse.show').forEach(openMenu => {
                if (openMenu !== collapseElement) {
                    openMenu.classList.remove('show');
                }
            });

            // Ouvrir ou fermer le menu cliqué
            collapseElement.classList.toggle('show', !isOpen);
        });
    });
</script>
