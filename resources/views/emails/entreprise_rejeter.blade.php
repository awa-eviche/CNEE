<!DOCTYPE html>
<html>
<head>
    <title>Rejet d'adhésion</title>
</head>
<body>
    <h1>Bonjour {{ $entreprise->nomentreprise }}</h1>
    
    <p>Nous regrettons de vous informer que votre demande a été rejetée. Voici les motifs du rejet :</p>
    <p>{{ $motif }}</p>
    
    <p>Merci de votre compréhension.</p>
    <p>Cordialement,</p>
    <p>L'équipe de la Direction de l'Emploi</p>
</body>
</html>
