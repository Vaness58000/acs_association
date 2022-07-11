document.querySelectorAll(".delete_produit").forEach(element => {
    element.addEventListener("click", function(event){
        let deleteP = confirm('Are you sure you want to delete this item?');
        let id = document.getElementById('id_produit').value;
        if(deleteP) {
            document.location.href="/produits/delete/"+id;
        }
    })
});

document.querySelectorAll(".delete_categorie").forEach(element => {
    element.addEventListener("click", function(event){
        let deleteP = confirm('Are you sure you want to delete this item?');
        let id = document.getElementById('id_categorie');
        if(deleteP) {
            //document.location.href="/produits/delete/"+id;
        }
    })
}); 