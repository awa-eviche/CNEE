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
            <form action="{{ route('allocation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
           
              <div class="col-md-12">
                <div class="card">
                 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-6">
                      <div class="form-group">
 <label for="profil_id">Entreprises </label>
 
    <input type="text" class="form-control"  id="entreprise_id" name="entreprise_id"  value="{{ $entreprise->nomentreprise}}" disabled>
    <input type="hidden" class="form-control"  id="entreprise_id" name="entreprise_id" value="{{ $entreprise->id}}" >
</div>
<div class="form-group">
    <label for="retenu_id">Demandeur</label>
    <select class="form-control" name="retenu_id" id="retenu_id">
        <option value="">Selectionner un de vos demandeurs</option>
        @foreach($retenu as $rete)
            @php
                // Conversion de la date d'échéance en timestamp
                $dateEcheanceTimestamp = strtotime($rete->dateecheance);
                // Timestamp actuel
                $nowTimestamp = time();
                // Calcul de la différence en jours
                $daysDifference = abs($dateEcheanceTimestamp - $nowTimestamp) / (60 * 60 * 24);
                // Définir le seuil (par exemple 10 jours)
                $isNear = $daysDifference <= 10;
            @endphp
            <option value="{{ $rete->id }}" @if($isNear) style="color: red;" @endif>
                {{ $rete->demandeurprofil->demandeur->prenom }} 
                {{ $rete->demandeurprofil->demandeur->nom }}
                @if($isNear)
                  -  {{ date('Y-m-d', $dateEcheanceTimestamp) }}
                @endif
            </option>
        @endforeach
    </select>
</div>

                        <div class="form-group">
                          <label for="datenaissance">Secteur d'activité</label>
                          <select   class="form-control" name="secteur_id" id="">
                     
                            <option value=""> Selectionner un secteur</option>
                            @foreach($secteur as $sect)
                            <option value="{{ $sect->id }}"> {{ $sect->libelle}}</option>
                            @endforeach
                          </select>
                        </div>
                      
                        <div class="form-group">
                          <label for="datenaissance">Partie entreprise</label>
                          <input type="text" class="form-control" id="ContrePartie" name="ContrePartie" placeholder="Votre part entreprise" oninput="calculerMontantTotal()" />
                        </div>

                        

                      </div>
                      
                      
                      <div class="col-md-6 col-6">
                        
                      <div class="form-group">
                          <label for="anneeAdhesion">Classification</label>
                          <select   class="form-control" name="classification_id" id="">
                     
                     <option value=""> Selectionner une classification</option>
                     @foreach($classification as $classe)
                     <option value="{{ $classe->id }}"> {{ $classe->libelle}}</option>
                     @endforeach
                   </select>
                        </div>
                        <div class="form-group">
  <label for="datenaissance">Mois</label>
  <select class="form-control" name="mois[]"  id="mois"   multiple  onchange="calculerMontantTotal()">
      <option value="">Selectionner un mois</option>
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

                      
                        <div class="form-group">
                          <label for="datenaissance">Contre partie Etat</label>
                          <input type="text" class="form-control" id="partieEtat" name="partieEtat" placeholder="Votre Durée de la convention" oninput="calculerMontantTotal()" />
                        </div>
                        <div class="form-group">
  <label for="montantTotalAffiche">Montant Total</label>
  <input type="text" class="form-control" id="montantTotalAffiche" placeholder="Votre Durée de la convention" readonly/>
</div>

<!-- Montant Total réel (caché) : soumis -->
<input type="hidden" id="montantTotal" name="montantTotal" />
                       

                        </div>
                      </div>
                    </div>
                    <div class="card-action">
                    <button class="btn btn-success">Enregister</button> 
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
    // Récupération des valeurs des inputs
    let contrePartie = parseFloat(document.getElementById('ContrePartie').value) || 0;
    let partieEtat   = parseFloat(document.getElementById('partieEtat').value) || 0;
    
    // Somme des deux valeurs
    let baseValue = contrePartie + partieEtat;
    
    // Récupération du select des mois et calcul du nombre de mois sélectionnés
    let moisSelect = document.getElementById('mois');
    let selectedMois = Array.from(moisSelect.selectedOptions).filter(option => option.value !== "");
    let multiplier = selectedMois.length;
    
    // Calcul du montant total (numérique)
    let montantTotal = baseValue * multiplier;
    
    // Format d'affichage : "baseValue * multiplier = montantTotal"
    let formattedResult = baseValue + " * " + multiplier + " = " + montantTotal;
    
    // Mise à jour des champs
    document.getElementById('montantTotalAffiche').value = formattedResult;
    document.getElementById('montantTotal').value = montantTotal; // Ce champ sera validé comme numérique
}
</script>

  </body>
</html>
