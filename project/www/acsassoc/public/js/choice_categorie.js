document.getElementById("categorie").addEventListener("change", function() {
    let choice = document.getElementById("categorie").value;
    document.location.href="/main/produits/categorie/"+choice;
})