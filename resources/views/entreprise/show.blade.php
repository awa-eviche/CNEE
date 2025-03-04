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
<style>
  .bg-success {
    background-color: #28a745; /* Vert */
    color: white; /* Texte blanc */
}

.bg-danger {
    background-color: #dc3545; /* Rouge */
    color: white; /* Texte blanc */
}

</style>
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
                <h3 class="fw-bold mb-3">Gestion des Entreprises</h3>
                <h6 class="op-7 mb-2">Convention Nationale Etat Employeur</h6>
                <div class="page-header">
                <div class="page-header">
              <h3 class="fw-bold mb-3"></h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="{{ route('dashboard') }}">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="{{ route('entreprise.index') }}">Gestion entreprise</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Détail entreprise</a>
                </li>
              </ul>
            </div>
            </div>
              </div>
                
              
              
           
            </div>
            <div class="row">
           
              <div class="col-md-12">
                <div class="card">
                 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-6">
                        <div class="form-group">
                          <label for="nom">Nom entreprise</label>
                          <input
                            type="text" class="form-control" id="nom" value="{{ $entreprise->nomentreprise ?? ' - ' }}" readonly />
                         
                        </div>

                        
                       

                        <div class="form-group">
                          <label for="datenaissance">Adresse</label>
                          <input type="text" class="form-control" id="datenaissance" value="{{ $entreprise->adresse ?? ' - ' }}"readonly />
                        </div>

                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="text" class="form-control" id="email" name="email" value="{{ $entreprise->email ?? ' - ' }}"readonly />
                        </div>

                        <div class="form-group">
                          <label for="adresse">Téléphone</label>
                          <input type="text" class="form-control" id="adresse" value="{{ $entreprise->tel ?? ' - ' }}" readonly/>
                         
                        </div>
                     
<div class="form-group">
 <label for="region">Département</label>
 <input  type="text" class="form-control" id="departement" value="{{ $entreprise->departement ?? ' - ' }}" readonly />

</div>

<div class="form-group">
 <label for="region">Forme juridique</label>
 <input  type="text" class="form-control" id="departement" value="{{ $entreprise->formj ?? ' - ' }}" readonly />

</div>

  <div class="form-group">
 <label for="profil_id">Activité:</label>
 <input type="text" class="form-control" id="adresse" value="{{ $entreprise->activite ?? ' - ' }}" readonly/>

</div>

                       
                     
                      </div>

                      
                      <div class="col-md-6 col-6">
                        
                      <div class="form-group">
                          <label for="prenom">Secteur d'activité</label>
                          <input type="text" class="form-control"value="{{ $entreprise->secteur ?? ' - ' }}" readonly
                          />
                        </div>
                        <div class="form-group">
                          <label for="lieunaissance">Ninea</label>
                          <input  type="text" class="form-control" id="lieunaissance" value="{{ $entreprise->ninea ?? ' - ' }}" readonly />
                        </div>
                        <div class="form-group">
    <label for="sexe">Regitre de commerce</label>
    <input  type="text" class="form-control" id="lieunaissance" value="{{ $entreprise->regitcom ?? ' - ' }}" readonly />

</div>

                        <div class="form-group">
 <label for="niveaux_id">Effectif entreprise</label>
 <input  type="text" class="form-control" id="lieunaissance" value="{{ $entreprise->nombreemployer ?? ' - ' }}" readonly />

</div>

<div class="form-group">
 <label for="region">Région</label>
 <input  type="text" class="form-control" id="region" value="{{ $entreprise->region ?? ' - ' }}" readonly />

</div>
<div class="form-group">
    <label for="region">Statut</label>
    <input type="text" class="form-control {{ $entreprise->statut == 'validé' ? 'btn btn-success' : ($entreprise->statut == 'rejeté' ? 'btn btn-danger' : '') }}" 
           id="region" value="{{ $entreprise->statut ?? ' - ' }}" disabled />
</div>


<div class="form-group">
    @if($entreprise->dossier)
        <a href="{{ Storage::url('dossiers/' . $entreprise->dossier) }}" target="_blank" class="btn btn-primary">
            Voir le fichier d'adhésion: {{ basename($entreprise->dossier) }}
        </a>
    @else
        <p>Aucun fichier disponible.</p>
    @endif
</div>
<div class="form-group"> 
    @if($entreprise->quitus)
        <a href="{{ Storage::url('quitus/' . $entreprise->quitus) }}" target="_blank" class="btn btn-primary">
            Voir le fichier quitus: {{ basename($entreprise->quitus) }}
        </a>
    @else
        <p>Aucun fichier disponible.</p>
    @endif
</div>
<div class="form-group">
    @if($entreprise->attestation)
        <a href="{{ Storage::url('attestations/' . $entreprise->attestation) }}" target="_blank" class="btn btn-primary">
            Voir le fichier attestation: {{ basename($entreprise->attestation) }}
        </a>
    @else
        <p>Aucun fichier disponible.</p>
    @endif
</div>


                        </div>
                    
                      </div>

                      
                     
                    </div>
                    
                  </div> 
                  @if (auth()->user()->role && auth()->user()->role->name == 'superadmin')
                  <div class="card-action  d-flex gap-2"">
                 <form action="{{ route('entreprise.valider', $entreprise->id) }}" method="post" id="validerForm">
                   @csrf
                  <button type="submit" class="btn btn-success"  id="validerButton">
                      Valider et envoyer un e-mail
                  </button>
                  </form>
                   <form action="{{ route('entreprise.rejeter', $entreprise->id) }}" method="post">
                      @csrf
<!-- Bouton d'ouverture du modal -->
<a  href="#"data-bs-toggle="modal" data-bs-target="#authentication-modal" 
    class="btn btn-primary">
    Rejeter et envoyer un mail
</a>

<!-- Modal -->
<div id="authentication-modal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header">
                <h3 class="modal-title text-xl font-semibold">Envoyer le motif du rejet</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Corps du modal -->
            <div class="modal-body">
                <form action="#" class="space-y-4">
                    <div class="mb-3">
                        <label for="motif" class="form-label">Motif</label>
                        <textarea id="motif" name="motif" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>


                    </form> 

                     <form action="{{ route('entreprise.desactiver', $entreprise->id) }}" method="post">
        @csrf
       
        <button type="submit" class="btn {{ $entreprise->est_actif ? 'btn-success' : 'btn-danger' }}" style="color: white;">
    <i class="fa {{$entreprise->est_actif ? 'fa-check' : 'fa-times'}}"></i>&nbsp;{{$entreprise->est_actif ? 'Activer' : 'Désactiver'}}
</button>



    </form>
                  </div>
                
                  @endif
                </div>
              
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

    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script src="assets/js/kaiadmin.min.js"></script>

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
                // Type et style de la notification
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
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('validerForm');
        const button = document.getElementById('validerButton');

        form.addEventListener('submit', function(event) {
            // Désactiver le bouton
            button.disabled = true;
            button.innerText = 'Envoi en cours...'; // Changer le texte du bouton
        });
    });
</script>


  </body>

</html>
