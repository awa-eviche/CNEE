<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Adhésion CNEE</title>
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets1/css/roboto-font.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets1/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css')}}">
	<!-- datepicker -->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets1/css/jquery-ui.min.css')}}">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('assets1/css/style.css')}}"/>
</head>
<body>
<div class="page-content" style="background-image: url('{{ asset('assets1/images/wizard-v3.jpg')}}')">

		<div class="wizard-v3-content">
			<div class="wizard-form">
				<div class="wizard-header">
					<h3 class="heading">Formulaire d'adhesion à la convention Etat Employeur </h3>
					<p>Fiche d'inscription</p>
				</div>
				<form class="form-register" action="{{ route('entreprise.store') }}" method="POST" enctype="multipart/form-data">
    @csrf 
	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div id="form-total">
        <!-- SECTION 1 -->
        <h2>
            <span class="step-icon"><i class="zmdi zmdi-account"></i></span>
            <span class="step-text">Information</span>
        </h2>
        <section>
            <div class="inner">
                <h3>Information de l'entreprise:</h3>
                <div class="form-row">
                    <div class="form-holder form-holder-2">
                        <label class="form-row-inner">
                            <input type="text" name="nomentreprise" id="fullname-val" class="form-control" required>
                            <span class="label">Nom entreprise</span>
                            <span class="border"></span>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-holder form-holder-2">
                        <label class="form-row-inner">
                            <input type="text" class="form-control" id="adresse" name="adresse" required>
                            <span class="label">Adresse</span>
                            <span class="border"></span>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-holder form-holder-2">
                        <label class="form-row-inner">
                            <input type="email" name="email" id="email-val" class="form-control" required>
                            <span class="label">Email</span>
                            <span class="border"></span>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-holder form-holder-2">
                        <label class="form-row-inner">
                            <input type="text" name="tel" id="phone-val" class="form-control" required>
                            <span class="label">Téléphone</span>
                            <span class="border"></span>
                        </label>
                    </div>
                </div>
                
            </div>
        </section>

        <!-- SECTION 2 -->
        <h2>
            <span class="step-icon"><i class="zmdi zmdi-lock"></i></span>
            <span class="step-text">Entreprise</span>
        </h2>
        <section>
            <div class="inner">
                <h3>Détails Entreprise:</h3>
                <div class="form-row">
                    <div class="form-holder">
                        <label class="form-row-inner">
                            <input type="text" class="form-control" id="activite-val" name="activite" required>
                            <span class="label">Activité Principal</span>
                            <span class="border"></span>
                        </label>
                    </div>
                    <div class="form-holder">
                        <label class="form-row-inner">
                            <input type="text" class="form-control" id="secteur-val" name="secteur" required>
                            <span class="label">Secteur d'activité</span>
                            <span class="border"></span>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-holder">
                        <label class="form-row-inner">
                            <input type="text" class="form-control" id="ninea-val" name="ninea" required>
                            <span class="label">NINEA</span>
                            <span class="border"></span>
                        </label>
                    </div>
                    <div class="form-holder">
                        <label class="form-row-inner">
                            <input type="text" class="form-control" id="regit-val" name="regitcom" required>
                            <span class="label">Régistre de commerce</span>
                            <span class="border"></span>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-holder form-holder-2">
                        <label class="form-row-inner" style="margin-bottom: 15px; display: flex; flex-direction: column;">
                            <span class="label">Nombre Employeur</span>
                            <input type="text" class="form-control" id="date-val" name="nombreemployer" required>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-holder form-holder-2">
                        <label class="form-row-inner" style="margin-bottom: 15px; display: flex; flex-direction: column;">
                            <span class="label">Joindre le fichier d'adhésion</span>
                            <input type="file" class="form-control" id="file-val" name="dossier" required>
                        </label>
                    </div>
                </div>
              
            </div>
        </section>

        <!-- SECTION 4 -->
        <h2>
            <span class="step-icon"><i class="zmdi zmdi-receipt"></i></span>
            <span class="step-text">Confirmation</span>
        </h2>
        <section>
            <div class="inner">
                <h3>Détails Confirmation:</h3>
                <div class="form-row table-responsive">
                    <table class="table">
                        <tbody>
                            <tr class="space-row">
                                <th>Nom Entreprise:</th>
                                <td id="fullname-val-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Adresse:</th>
                                <td id="adresse-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Email:</th>
                                <td id="email-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Téléphone:</th>
                                <td id="phone-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Activité Principal:</th>
                                <td id="activite-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Secteur Activité:</th>
                                <td id="secteur-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Ninea:</th>
                                <td id="ninea-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Registre de commerce:</th>
                                <td id="regit-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Nombre Employeur:</th>
                                <td id="date-confirm"></td>
                            </tr>
                            <tr class="space-row">
                                <th>Fichier à joindre:</th>
                                <td id="file-confirm"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </section>
    </div>
</form>

			</div>
		</div>
	</div>
	<script src="{{ asset('assets1/js/jquery-3.3.1.min.js')}}"></script>
	<script src="{{ asset('assets1/js/jquery.steps.js')}}"></script>
	<script src="{{ asset('assets1/js/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('assets1/js/main.js')}}"></script>
	
</body>
</html>