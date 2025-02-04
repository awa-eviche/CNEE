<!DOCTYPE>
<html>
<head>
    <title>Confirmation d'inscription</title>
</head>
<body>
    <h1>Bonjour {{ $entreprise->nomentreprise }}</h1>
    <p>Nous sommes ravis de vous informer que votre inscription a été enregistrée avec succès.</p>
    <p><strong>Détails de votre inscription :</strong></p>
    <ul>
        <li><strong>Nom de l'entreprise :</strong> {{ $entreprise->nomentreprise }}</li>
        <li><strong>Email :</strong> {{ $entreprise->email }}</li>
        <li><strong>Adresse :</strong> {{ $entreprise->adresse }}</li>
        <li><strong>Activité :</strong> {{ $entreprise->activite }}</li>
        <li><strong>Secteur :</strong> {{ $entreprise->secteur }}</li>
    </ul>
    <p>Merci de nous faire confiance. Une equipe de la DE sera déployée pour une visite de prospection à une date ultérieure.</p>
    <p>Cordialement,</p>
    <p>L'équipe de la Direction de l'Emploi</p>
</body>
</html>
