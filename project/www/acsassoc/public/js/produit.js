let big_image = document.getElementById('big_image'); //récupère l'élément à partir de l'Id
document.querySelectorAll(".produit_img").forEach(element => {//selectionne la class [ou l'id]
    element.addEventListener("click", function(event){//signaler l'action de l'événement
    big_image.src = this.src; //on remplace la src de la grande image par la src de la petite image
console.log("test");
})
}); 