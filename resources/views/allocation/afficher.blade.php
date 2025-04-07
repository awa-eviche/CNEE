<!DOCTYPE html>
<html lang="en">
  <head>
   @include('layouts.head')
  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
       @include('layouts.sidebar')
    
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.html" class="logo">
                <img
                  src="assets/img/kaiadmin/logo_light.svg"
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
          <!-- Navbar Header -->
          @include('layouts.nav')
          <!-- End Navbar -->
        </div>
        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Gestion des allocations</h3>
                <h6 class="op-7 mb-2">Convention Nationale Etat Employeur</h6>
              </div>
              <!-- <div class="ms-md-auto py-2 py-md-0">
            
                <a href="#" class="btn btn-primary btn-round">Ajouter</a>
              </div> -->
            </div>
            <div class="row">
            <form id="allocationForm" action="{{ route('allocation.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <!-- Colonne gauche -->
          <div class="col-md-6 col-6">
            <!-- Entreprise -->
            <div class="form-group">
              <label>Entreprises</label>
              <input type="text" class="form-control" value="{{ $entreprise->nomentreprise }}" disabled>
              <input type="hidden" name="entreprise_id" value="{{ $entreprise->id }}">
            </div>
            
            <div class="form-group">
              <label>Demandeur</label>
              <select class="form-control" name="retenu_id" id="retenu_id" required>
    <option value="">Sélectionner un de vos demandeurs</option>
    @foreach($retenu as $rete)
        @php
            // Conversion de la date d'échéance en timestamp
            $dateEcheanceTimestamp = strtotime($rete->dateecheance);
            
            // Déterminer le trimestre de la date d'échéance
            $dueMonth = (int) date('n', $dateEcheanceTimestamp);
            if ($dueMonth <= 3) {
                $dueQuarter = 1;
            } elseif ($dueMonth <= 6) {
                $dueQuarter = 2;
            } elseif ($dueMonth <= 9) {
                $dueQuarter = 3;
            } else {
                $dueQuarter = 4;
            }
            
            // Déterminer le trimestre courant
            $currentMonth = (int) date('n');
            if ($currentMonth <= 3) {
                $currentQuarter = 1;
            } elseif ($currentMonth <= 6) {
                $currentQuarter = 2;
            } elseif ($currentMonth <= 9) {
                $currentQuarter = 3;
            } else {
                $currentQuarter = 4;
            }
            
            // Si la date d'échéance est dans le trimestre à venir, on affiche en rouge avec la date
            if ($dueQuarter > $currentQuarter) {
                $color = "red";
                $displayDate = " - " . date('Y-m-d', $dateEcheanceTimestamp);
            } else {
                // Dans le trimestre courant ou passé : affichage en noir sans date
                $color = "black";
                $displayDate = "";
            }
        @endphp
        <option value="{{ $rete->id }}" style="color: {{ $color }};">
            {{ $rete->demandeurprofil->demandeur->prenom }} {{ $rete->demandeurprofil->demandeur->nom }}{{ $displayDate }}
        </option>
    @endforeach
</select>


            </div>
            <!-- Secteur d'activité -->
            <div class="form-group">
              <label>Secteur d'activité</label>
              <!-- Champ visible affichant le libellé (non soumis) -->
              <input type="text" class="form-control" id="secteurAfficheDisplay" placeholder="Secteur" readonly>
              <!-- Champ hidden transmettant l'ID du secteur -->
              <input type="hidden" id="secteurAffiche" name="secteur_id" value="{{ old('secteur_id') }}">
            </div>
            <!-- Partie entreprise -->
            <div class="form-group">
              <label>Partie entreprise</label>
              <input type="text" required class="form-control" id="ContrePartie" name="ContrePartie" placeholder="Votre part entreprise" oninput="calculerMontantTotal()">
            </div>
          </div>
          <!-- Colonne droite -->
          <div class="col-md-6 col-6">
            <!-- Classification -->
            <div class="form-group">
              <label>Classification</label>
              <select class="form-control" name="classification_id" id="classification" onchange="updateSecteur()" required>
                <option value="">Sélectionner une classification</option>
                @foreach($classification as $classe)
                  <option value="{{ $classe->id }}" 
                          data-secteur="{{ $classe->secteur->libelle ?? '' }}"
                          data-secteur-id="{{ $classe->secteur->id ?? '' }}">
                    {{ $classe->libelle }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- Mois -->
            <div class="form-group">
              <label>Mois</label>
              <select class="form-control" name="mois[]" id="mois" multiple onchange="calculerMontantTotal()" required>
                <option value="">Sélectionner un mois</option>
                <option value="Janvier">Janvier</option>
                <option value="Février">Février</option>
                <option value="Mars">Mars</option>
                <option value="Avril">Avril</option>
                <option value="Mai">Mai</option>
                <option value="Juin">Juin</option>
                <option value="Juillet">Juillet</option>
                <option value="Aout">Aout</option>
                <option value="Septembre">Septembre</option>
                <option value="Octobre">Octobre</option>
                <option value="Novembre">Novembre</option>
                <option value="Décembre">Décembre</option>
              </select>
            </div>
            <!-- Contre partie Etat -->
            <div class="form-group">
              <label>Contre partie Etat</label>
              <input type="text" class="form-control" id="partieEtat" name="partieEtat" placeholder="Votre Durée de la convention" oninput="calculerMontantTotal()">
            </div>
            <!-- Montant Total -->
            <div class="form-group">
              <label>Montant Total</label>
              <input type="text" class="form-control" id="montantTotalAffiche" placeholder="Calculé automatiquement" readonly>
            </div>
            <input type="hidden" id="montantTotal" name="montantTotal">
          </div>
        </div>
      </div>
      <div class="card-action">
        <button class="btn btn-success">Enregister</button>
      </div>
    </div>
  </div>
</form>

                </div>
              </div>
            </div>
          
        </div>
     
 <!--! footer-->
        @include('layouts.footer')
      </div>

      <!-- Custom template | don't include it in your project! -->
      <div class="custom-template">
        <div class="title">Settings</div>
        <div class="custom-content">
          <div class="switcher">
            <div class="switch-block">
              <h4>Logo Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="selected changeLogoHeaderColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeLogoHeaderColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Navbar Header</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red"
                ></button>
                <button
                  type="button"
                  class="selected changeTopBarColor"
                  data-color="white"
                ></button>
                <br />
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="dark2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="purple2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="light-blue2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="green2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="orange2"
                ></button>
                <button
                  type="button"
                  class="changeTopBarColor"
                  data-color="red2"
                ></button>
              </div>
            </div>
            <div class="switch-block">
              <h4>Sidebar</h4>
              <div class="btnSwitch">
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="white"
                ></button>
                <button
                  type="button"
                  class="selected changeSideBarColor"
                  data-color="dark"
                ></button>
                <button
                  type="button"
                  class="changeSideBarColor"
                  data-color="dark2"
                ></button>
              </div>
            </div>
          </div>
        </div>
        <div class="custom-toggle">
          <i class="icon-settings"></i>
        </div>
      </div>
      <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
     <script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success'))
            $.notify({
               
                message: '{{ session('success') }}'
            }, {
               
                type: 'success',
                delay: 3000,
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        @endif
    });
</script>
<script>
function calculerMontantTotal() {
    let contrePartie = parseFloat(document.getElementById('ContrePartie').value) || 0;
    let partieEtat   = parseFloat(document.getElementById('partieEtat').value) || 0;
    let baseValue = contrePartie + partieEtat;
    
    let moisSelect = document.getElementById('mois');
    let selectedMois = Array.from(moisSelect.selectedOptions).filter(option => option.value !== "");
    let multiplier = selectedMois.length;
    
    let montantTotal = baseValue * multiplier;
    let formattedResult = baseValue + " * " + multiplier + " = " + montantTotal;
    
    document.getElementById('montantTotalAffiche').value = formattedResult;
    document.getElementById('montantTotal').value = montantTotal;
}

function updateSecteur() {
    var classificationSelect = document.getElementById("classification");
    var selectedOption = classificationSelect.options[classificationSelect.selectedIndex];
    
    // Récupérer le libellé et l'ID du secteur depuis les attributs data
    var secteurLibelle = selectedOption.getAttribute("data-secteur") || '';
    var secteurId = selectedOption.getAttribute("data-secteur-id") || '';
    
    // Mettre à jour le champ visible (affichage) et le champ hidden (valeur envoyée)
    document.getElementById("secteurAfficheDisplay").value = secteurLibelle;
    document.getElementById("secteurAffiche").value = secteurId;
}
</script>

  </body>
</html>
