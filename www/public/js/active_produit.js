window.onload = () => {
    let activer = document.querySelectorAll("[type=checkbox]")
    for (let bouton of activer) {
        bouton.addEventListener("click", function () {
            let xmlhttp = new XMLHttpRequest;
            xmlhttp.open("get", `/produits/activer/${this.dataset.id}`)
            xmlhttp.send()
        })
    }
}