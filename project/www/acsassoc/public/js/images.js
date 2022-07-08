window.onload = () => {
    // Gestion des boutons "Supprimer"
    let links = document.querySelectorAll(".images");
    
    // On boucle sur links
    for(link of links){
        // On écoute le clic
        link.addEventListener("click", function(e){
            // On empêche la navigation
            e.preventDefault();

            // On demande confirmation
            if(confirm("Voulez-vous supprimer cette image ?")){
                // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    // On récupère la réponse en JSON
                    response => response.json()
                ).then(data => {
                    if(data.success)
                        this.parentElement.remove()
                    else
                        alert(data.error)
                }).catch(e => alert(e))
            }
        })
    }

    // Gestion des boutons "Supprimer"

  document.querySelectorAll("#manuel").forEach((element) => {
    //selectionne la class [ou l'id]
    element.addEventListener("click", function (e) {
      // On empêche la navigation
      e.preventDefault();

      // On demande confirmation
      if (confirm("Voulez-vous supprimer ce manuel ?")) {
        // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
        fetch(this.getAttribute("href"), {
          method: "DELETE",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ _token: this.dataset.token }),
        })
          .then(
            // On récupère la réponse en JSON
            (response) => response.json()
          )
          .then((data) => {
            if (data.success) {
                document.getElementById("manuel_src_img_id").style.display = "none";
                document.getElementById("manuel_src_id").style.display = "flex";
                //this.parentElement.style

            }
            else alert(data.error);
          })
          .catch((e) => alert(e));
      }
    });
  });
  document.querySelectorAll("#ticket").forEach((element) => {
    //selectionne la class [ou l'id]
    element.addEventListener("click", function (e) {
      // On empêche la navigation
      e.preventDefault();

      // On demande confirmation
      if (confirm("Voulez-vous supprimer ce ticket ?")) {
        // On envoie une requête Ajax vers le href du lien avec la méthode DELETE
        fetch(this.getAttribute("href"), {
          method: "DELETE",
          headers: {
            "X-Requested-With": "XMLHttpRequest",
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ _token: this.dataset.token }),
        })
          .then(
            // On récupère la réponse en JSON
            (response) => response.json()
          )
          .then((data) => {
            if (data.success) {
                document.getElementById("ticket_src_img_id").style.display = "none";
                document.getElementById("ticket_src_id").style.display = "flex";
                //this.parentElement.style

            }
            else alert(data.error);
          })
          .catch((e) => alert(e));
      }
    });
  });
}