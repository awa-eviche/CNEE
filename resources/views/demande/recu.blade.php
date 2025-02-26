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
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                            <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
                        </div>
                        <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
                    </div>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                @include('layouts.nav')
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Liste des demandeurs reçus</h3>
                            <h6 class="op-7 mb-2">Convention Nationale Etat Employeur</h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" style="text-align:center">Liste des demandeurs reçus</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <form action="{{ route('demande.enregistrerRetenu') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="entreprise_id" value="{{ $entrepriseId }}">
                                            <input type="hidden" name="demande_id" value="{{ $demandeId }}">
                                            <table id="basic-datatables" class="display table table-striped table-hover" style="table-layout: fixed; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20%;">Nom</th>
                                                        <th style="width: 20%;">Prénom</th>
                                                        <th style="width: 20%;">Profil</th>
                                                        <th style="width: 20%;">Niveau d'étude</th>
                                                        <th style="width: 10%;">Retenu</th>
                                                        <th style="width: 15%;">Date Prise d'effet</th>
                                                        <th style="width: 15%;">Date d'échéance</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Nom</th>
                                                        <th>Prénom</th>
                                                        <th>Profil</th>
                                                        <th>Niveau d'étude</th>
                                                        <th>Retenu</th>
                                                        <th>Date Prise d'effet</th>
                                                        <th>Date d'échéance</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($reponses as $dem)
                                                    <tr>
                                                        <td>{{ $dem->demandeurprofil->demandeur->nom ?? '-' }}</td>
                                                        <td>{{ $dem->demandeurprofil->demandeur->prenom ?? '-' }}</td>
                                                        <td>{{ $dem->demande->profil->libelle ?? '-' }}</td>
                                                        <td>{{ $dem->demande->niveaux->libelle ?? '-' }}</td>
                                                        <td><input type="checkbox" name="demandeur_profils[]" value="{{ $dem->demandeurprofil->id }}"></td>
                                                        <td><input type="date" name="date_prises_effet[{{ $dem->demandeurprofil->id }}]" class="form-control"></td>
                                                        <td><input type="date" name="date_echeances[{{ $dem->demandeurprofil->id }}]" class="form-control"></td>
                                                    </tr>
                                                    @endforeach   
                                                </tbody>
                                            </table>
                                            <div class="text-left mt-3">
                                                <button type="submit" class="btn btn-primary">Soumettre</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    <!-- Core JS Files -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/kaiadmin.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#basic-datatables").DataTable({
                language: {
                    lengthMenu: "Afficher _MENU_ entrées",
                    paginate: {
                        previous: "Précédent",
                        next: "Suivant"
                    }
                }
            });
        });
    </script>
    
</body>
</html>
