$(function() {
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate: '<div class="title">#title#</div>',
        labels: {
            previous: 'Précédent',
            next: 'Suivant',
            finish: 'Envoyer',
            current: ''
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            // Permet de revenir à l'étape précédente
            if (newIndex < currentIndex) {
                return true;
            }

            // Récupérer les données des champs
            var fullname = $('#fullname-val').val();
            var adresse = $('#adresse').val();
            var email = $('#email-val').val();
            var phone = $('#phone-val').val();
            var activite = $('#activite-val').val();
            var secteur = $('#secteur-val').val();
            var ninea = $('#ninea-val').val();
            var registre = $('#regit-val').val();
            var dateCreation = $('#date-val').val();
            var fileInput = $('#file-val').val();

            // Vérification des champs requis
            if (currentIndex === 0) {
                if (!fullname || !adresse || !email || !phone) {
                    alert("Veuillez remplir tous les champs requis dans cette étape.");
                    return false;
                }
            }

            if (currentIndex === 1) {
                if (!activite || !secteur || !ninea || !registre || !dateCreation || !fileInput) {
                    alert("Veuillez remplir tous les champs requis dans cette étape.");
                    return false;
                }
            }

            // Afficher les données dans la section de confirmation
            $('#fullname-val-confirm').text(fullname);
            $('#adresse-confirm').text(adresse);
            $('#email-confirm').text(email);
            $('#phone-confirm').text(phone);
            $('#activite-confirm').text(activite);
            $('#secteur-confirm').text(secteur);
            $('#ninea-confirm').text(ninea);
            $('#regit-confirm').text(registre);
            $('#date-confirm').text(dateCreation);
            $('#file-confirm').text(fileInput.split('\\').pop()); // Afficher le nom du fichier

            return true; // Permet de passer à l'étape suivante
        },
        onFinished: function(event, currentIndex) {
            // Soumettre le formulaire lorsque l'utilisateur clique sur "Envoyer"
            $(".form-register").submit();
        }
    });
});
