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
          <!-- End Navbar -->
        </div>
        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Gestion des archives</h3>
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
 <label for="profil_id">Entreprises validés </label>
 <input type="text" class="form-control" id="type" name="type" placeholder="Enter votre type"  value="{{ $archive->entreprise->nomentreprise ?? ' - ' }}" disabled />

</div>

                        <div class="form-group">
                          <label for="nom">Type d'archive</label>
                          <input type="text" class="form-control" id="type" name="type" placeholder="Enter votre type"  value="{{ $archive->type ?? ' - ' }}" disabled />
                         
                        </div>
                        <div class="form-group">
                          <label for="datenaissance">Durée de la convention</label>
                          <input type="text" class="form-control" id="dureeConv" name="dureeConv" placeholder="Votre Durée de la convention" value="{{ $archive->dureeConv ?? ' - ' }}"disabled  />
                        </div>
                      </div>

                      
                      <div class="col-md-6 col-6">
                        
                      <div class="form-group">
                          <label for="anneeAdhesion">Année d'adhésion</label>
                          <input
                            type="text"
                            class="form-control"
                            id="anneeAdhesion"
                            name="anneeAdhesion"
                            placeholder="Votre année d'adhésion" value="{{ $archive->anneeAdhesion ?? ' - ' }}" disabled 
                          />
                        </div>
                        <div class="form-group">
                          <label>Fichier à joindre</label>
                          @if($archive->file)
        <a href="{{ asset('storage/' . $archive->file) }}" target="_blank" class="btn btn-primary">
            Voir le fichier : {{ basename($archive->file) }}
        </a>
    @else
        <p>Aucun fichier disponible.</p>
    @endif
                        </div>

                        <div class="form-group">
                          <label for="anneeAdhesion">Année d'adhésion</label>
                          <input
                            type="text"
                            class="form-control"
                            id="anneeAdhesion"
                            name="anneeAdhesion"
                            placeholder="Votre année d'adhésion" value="{{ $archive->anneeAdhesion ?? ' - ' }}" disabled 
                          />
                        </div>
                        <div class="form-group">
                          <label>Autres documents:</label>
                          <br>
                          @foreach($archive->fichiers as $fichier)
    
        <a href="{{ Storage::url($fichier->file) }}" target="_blank" class="btn btn-primary">{{ $fichier->type }} </a>
    
                @endforeach
                        </div>


                        </div>
                      </div>
                    </div>
                    <div class="card-action"style="display: flex; gap: 10px;">
                    
                    <a href="{{ route('archive.edit', $archive->id) }} " class="btn btn-success">Modifier</a>
                    <form action="{{ route('archive.destroy', $archive->id) }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette archive ?');">Supprimer</button>
</form>

                    <a href="#" data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Ajouter un nouveau fichier</a>
    <div id="authentication-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Ajout d'un fichier à l'entreprise {{ $archive->entreprise->nomentreprise ?? ' - ' }}
                    </h3>
                    <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
        
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('fichiers.store', $archive->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div>
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type de dossier</label>
                            <input type="text" name="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="type" required />
                        </div>
                        <br>
                        <div>
                            <label for="file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fichier à joindre</label>
                            <input type="file" name="file" id="password" placeholder="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
                        </div>
                        <br>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Enregister</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
  </body>
</html>
