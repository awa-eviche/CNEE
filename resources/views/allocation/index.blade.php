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
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid">
    <!-- Section de recherche -->
    <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
    <form method="GET" action="{{ route('allocation.index') }}">
  <div class="input-group">
    <div class="input-group-prepend">
      <button type="submit" class="btn btn-search pe-1">
        <i class="fa fa-search search-icon"></i>
      </button>
    </div>
    <input type="text" name="nomentreprise" value="{{ request('nomentreprise') }}" placeholder="Rechercher entreprise..." class="form-control" />
  </div>
</form>

    </nav>

    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
      <!-- Recherche pour petit écran -->
      

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
            
            </div>
   
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title" style="text-align:center">Liste des entreprises</h4>
                  </div>
                <div class="card-body">
                <div class="row">
        <div class="col-md-12">
            <ul class="timeline">
            @if($entreprises->isEmpty())
    <div class="alert alert-warning">
        Aucune nom entreprise correspondant à  : <strong>{{ request('nomentreprise') }} </strong>n'est trouvable
    </div>
@else
    @foreach ($entreprises as $entreprise)
        <li class="{{ $loop->even ? 'timeline-inverted' : '' }}">
            <div class="timeline-badge {{ $entreprise->badge_class ?? 'info' }}">
                <!-- Badge visuel ici si tu veux -->
            </div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">{{ $entreprise->nomentreprise }}</h4>
                    <p>
                        <small class="text-muted">
                            <i class="fas fa-graduation-cap"></i>
                            Stagiaire : <strong>{{ $entreprise->retenus_count }}</strong>
                        </small>
                    </p>
                </div>
                <div class="timeline-body">
                    <p>Activité : {{ $entreprise->activite }}</p>
                </div>
                <div style="position: relative;">
                    <a href="{{ route('allocation.create', ['id' => $entreprise->id]) }}" class="btn btn-primary" style="left: 80px;">Voir une allocation</a>
                    <a href="{{ route('allocation.montant', ['id' => $entreprise->id]) }}" class="btn btn-secondary" style="left: 80px;">Montants dus</a>
                </div>
            </div>
        </li>
    @endforeach


              
            </ul>
            <div class="d-flex justify-content-center mt-3">
    {{ $entreprises->appends(request()->query())->links('pagination::bootstrap-4') }}
</div>

            @endif

        </div>
    </div>
                
</div>


      
      </div>
      @include('layouts.footer')
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
      $(document).ready(function () {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function () {
            this.api()
              .columns()
              .every(function () {
                var column = this;
                var select = $(
                  '<select class="form-select"><option value=""></option></select>'
                )
                  .appendTo($(column.footer()).empty())
                  .on("change", function () {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function () {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
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
