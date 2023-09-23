document.getElementById("select_cat").addEventListener("change", function() {
    let choice = document.getElementById("select_cat").value;
    document.location.href="/main/produits/categorie/"+choice;
})