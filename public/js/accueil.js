// Fonction pour afficher le détail du produit
function afficherDetail(button) {
    const idPro = button.getAttribute("id");

    document.getElementById("titreProduit").textContent = button.getAttribute("nom");
    document.getElementById("descriptionProduit").textContent = button.getAttribute("description");
    document.getElementById("prixProduit").textContent = button.getAttribute("prix");
    document.getElementById("imageProduit").src = button.getAttribute("image");
    document.getElementById("couleurChoisie").textContent = button.getAttribute("couleur");
    document.getElementById("tailleChoisie").textContent = button.getAttribute("taille");
    document.getElementById("idPro").textContent = idPro;

    
    const favoriForm = document.getElementById("favoriForm");
    favoriForm.action = `/favoris/ajouter/${idPro}`;
    
    document.getElementById("inputIdProduit").value = button.getAttribute("id");

    document.getElementById("aside").classList.add("active");
}

// Fonction pour ajouter ou retirer un produit des favoris
function toggleFavorite(button) {
    return true; 
}

//fermer le détail du produit
function fermerDetail(){
    document.getElementById("aside").classList.remove("active");
}