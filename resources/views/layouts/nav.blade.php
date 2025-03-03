<nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" >
            <div class="container-fluid">
              <nav
                class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex"
              >
                <div class="input-group">
                  <div class="input-group-prepend">
                    <button type="submit" class="btn btn-search pe-1">
                      <i class="fa fa-search search-icon"></i>
                    </button>
                  </div>
                  <input
                    type="text"
                    placeholder="Search ..."
                    class="form-control"
                  />
                </div>
                <div class="input-group-prepend">
             
                </div>
             
              </nav>

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
               
    

                <li class="nav-item topbar-icon dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
        <i class="fa fa-bell"></i>
      
            <span class="notification" id="notification-count">{{ $totalNotifications }}</span>
    
    </a>
    <ul class="dropdown-menu notif-box animated fadeIn">
        <li>
            <div class="dropdown-title">Vous avez {{ $totalNotifications }} nouvelles notifications</div>
        </li>
        <li>
            <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                   
                        <a href="{{ route('entreprise.index') }}">
                            <div class="notif-icon notif-primary"><i class="fa fa-user-plus"></i></div>
                            <div class="notif-content">
                                <span class="block" id="entreprises-count">{{ $nouveauxEntreprises }} nouvelles entreprises</span>
                            </div>
                        </a>
                   
                   
                        <a href="{{ route('demande.index') }}">
                            <div class="notif-icon notif-success"><i class="fa fa-comment"></i></div>
                            <div class="notif-content">
                                <span class="block" id="demandes-count">{{ $nouvellesDemandes }}  nouvelles demandes</span>
                            </div>
                        </a>
                
                </div>
            </div>
        </li>
    </ul>
</li>


                    
                <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" >
                            <i class="fas fa-power-off" style=" font-size:125%"></i>
                                  
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
              
                <li class="nav-item topbar-user dropdown hidden-caret">
                  
                <a class="dropdown-toggle profile-pic"data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    
                    <div class="avatar-sm">
                      <img
                        src="{{ asset('assets/img/profile.jpg')}}"
                        alt="..."
                        class="avatar-img rounded-circle"
                      />
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
                            <img
                              src="assets/img/profile.jpg"
                              alt="image profile"
                              class="avatar-img rounded"
                            />
                          </div>
                          <div class="u-text">
                            <h4>Hizrian</h4>
                            <p class="text-muted">hello@example.com</p>
                            <a
                              href="profile.html"
                              class="btn btn-xs btn-secondary btn-sm"
                              >View Profile</a>
                          </div>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-divider"></div>
                        
                        <div class="dropdown-divider">
                        <a class="dropdown-item" href="#">Account Setting</a>
                        <div class="dropdown-divider">
                     
                        </div>
                    
                        </div>
                      
                      </li>
                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
 document.addEventListener("DOMContentLoaded", function () {
    function fetchNotifications() {
        fetch("{{ route('notifications') }}")
            .then(response => response.json())
            .then(data => {
                const totalNotifications = data.totalNotifications;
                const nouveauxEntreprises = data.nouveauxEntreprises;
                const nouvellesDemandes = data.nouvellesDemandes;

                // Mise à jour du compteur de notification
                const notifCount = document.getElementById("notification-count");
                const notifTotal = document.getElementById("notif-total");

                if (totalNotifications > 0) {
                    notifCount.style.display = "inline-block";
                    notifCount.textContent = totalNotifications;
                    notifTotal.textContent = totalNotifications;
                } else {
                    notifCount.style.display = "none";
                    notifTotal.textContent = "0";
                }

                // Mise à jour des entreprises
                const notifEntreprise = document.getElementById("notif-entreprise");
                const entreprisesCount = document.getElementById("entreprises-count");

                if (nouveauxEntreprises > 0) {
                    notifEntreprise.style.display = "flex";
                    entreprisesCount.textContent = `${nouveauxEntreprises} nouvelles entreprises`;
                } else {
                    notifEntreprise.style.display = "none";
                }

                // Mise à jour des demandes
                const notifDemande = document.getElementById("notif-demande");
                const demandesCount = document.getElementById("demandes-count");

                if (nouvellesDemandes > 0) {
                    notifDemande.style.display = "flex";
                    demandesCount.textContent = `${nouvellesDemandes} nouvelles demandes`;
                } else {
                    notifDemande.style.display = "none";
                }
            })
            .catch(error => console.error("Erreur lors du chargement des notifications :", error));
    }

    
    setInterval(fetchNotifications, 10000);
    fetchNotifications(); // Charger immédiatement au chargement de la page
});

</script>