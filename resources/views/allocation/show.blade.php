<!DOCTYPE html>
<html lang="en">
  <head>
   @include('layouts.head')

   <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>


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
                  src="{{asset('assets/img/kaiadmin/logo_light.svg')}}"
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
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
          
              
           
              <div class="col-md-12">
                <div class="card">
                 
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-6">
                      <div class="form-group">
 <label for="profil_id">Entreprises </label>
 <input type="text" class="form-control" id="type" name="type" placeholder="Enter votre type"  value="{{ $allocation->entreprise->nomentreprise ?? ' - ' }}" disabled />

</div>

                        <div class="form-group">
                          <label for="nom">Demandeur</label>
                          <input type="text" class="form-control" id="type" name="type" placeholder="Enter votre type"  value="{{ $allocation->retenu->demandeurprofil->demandeur->prenom ?? ' - ' }} {{ $allocation->retenu->demandeurprofil->demandeur->nom ?? ' - ' }}" disabled />
                         
                        </div>
                        <div class="form-group">
                          <label for="datenaissance">Secteur d'activité</label>
                          <input type="text" class="form-control" id="dureeConv" name="dureeConv" placeholder="Votre Durée de la convention" value="{{ $allocation->secteur->libelle ?? ' - ' }}"disabled  />
                        </div>
                        <div class="form-group">
                          <label for="datenaissance">Classification</label>
                          <input type="text" class="form-control" id="dureeConv" name="debutconvention" placeholder="Votre Durée de la convention" value="{{ $allocation->classification->libelle ?? ' - ' }}"disabled  />
                        </div>
                        <div class="form-group">
                          <label for="datenaissance">Mois</label>
                          <input type="text" class="form-control" id="dureeConv" name="finconvention" placeholder="Votre fin de la convention" value="{{ $allocation->mois ?? ' - ' }}"disabled  />
                        </div>
                      </div>

                      
                      <div class="col-md-6 col-6">
                        
                      <div class="form-group">
                          <label for="anneeAdhesion">Partie Entreprise</label>
                          <input
                            type="text"
                            class="form-control"
                            id="anneeAdhesion"
                            name="anneeAdhesion"
                            placeholder="Votre année d'adhésion" value="{{ $allocation->ContrePartie ?? ' - ' }}" disabled 
                          />
                        </div>
                        <div class="form-group">
                          <label>Contre partie Etat</label>
                          <input
                            type="text"
                            class="form-control"
                            id="anneeAdhesion"
                            name="anneeAdhesion"
                            placeholder="Votre année d'adhésion" value="{{ $allocation->partieEtat ?? ' - ' }}" disabled 
                          />
                        </div>

                        <div class="form-group">
                          <label for="anneeAdhesion">Montant total</label>
                          <input
                            type="text"
                            class="form-control"
                            id="anneeAdhesion"
                            name="anneeAdhesion"
                            placeholder="Votre année d'adhésion" value="{{ $allocation->montantTotal ?? ' - ' }}" disabled 
                          />
                        </div>
                        <div class="form-group">
                          <label>Autres documents:</label>
                          <br>
                          
    
       
                        </div>


                        </div>
                      </div>
                    </div>
                    <div class="card-action"style="display: flex; gap: 10px;">
                    
                    <a href="{{ route('allocation.edit', $allocation->id) }} " class="btn btn-success">Modifier</a>
                    <form action="" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette archive ?');">Supprimer</button>
</form>

    

                  </div>
                  </div>
                </div>
              </div>
              
            </div>
        </div>
     
 <!--! footer-->
        @include('layouts.footer')
      </div>
    </div>
    <script>
  document.addEventListener("DOMContentLoaded", function () {
      const modalToggle = document.querySelector('[data-modal-toggle="authentication-modal"]');
      const modal = document.getElementById("authentication-modal");

      if (modalToggle && modal) {
          modalToggle.addEventListener("click", function () {
              modal.classList.toggle("hidden");
              modal.classList.toggle("flex");
          });

          // Gestion de la fermeture du modal
          const closeModalButton = modal.querySelector('[data-modal-hide="authentication-modal"]');
          if (closeModalButton) {
              closeModalButton.addEventListener("click", function () {
                  modal.classList.add("hidden");
                  modal.classList.remove("flex");
              });
          }
      }
  });
</script>

    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
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
  </body>
</html>
