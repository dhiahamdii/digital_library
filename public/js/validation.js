function validateDocumentForm() {
    var titre = document.getElementById('titre').value;
    var auteur = document.getElementById('auteur').value;
    var annee = document.getElementById('annee').value;
    var type = document.getElementById('type').value;

    if (titre.trim() === '' || auteur.trim() === '' || annee.trim() === '' || type === '') {
        alert('Tous les champs sont obligatoires.');
        return false;
    }

    if (isNaN(annee) || annee.length !== 4) {
        alert('L\'année doit être un nombre à 4 chiffres.');
        return false;
    }

    return true;
}

function validateSearchForm() {
    var annee = document.getElementById('annee').value;
    if (annee !== '' && (isNaN(annee) || annee.length !== 4)) {
        alert('L\'année doit être un nombre à 4 chiffres.');
        return false;
    }
    return true;
}