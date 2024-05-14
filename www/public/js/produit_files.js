function loadFilesImgs(event) {
    let files = event.target.files;
    let preview = document.getElementById("add_img");
    preview.innerHTML = "";
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      var imageType = /^image\//;
  
      if (!imageType.test(file.type)) {
        continue;
      }

      var img = document.createElement("img");
      img.setAttribute("alt", "Image");
      img.setAttribute("width", "150");
      img.file = file;
      preview.appendChild(img);

      var reader = new FileReader();
      reader.onload = (function(aImg) {
          return function(e) { 
              aImg.src = e.target.result;
            };
        })(img);
      reader.readAsDataURL(file);
    }
}

function loadFile(event) {
    let files = event.target.files;
    let preview = document.getElementById("produits_manuel_name");
    if(event.target.id == "produits_ticket_src") {
        preview = document.getElementById("produits_ticket_name");
    }
    preview.innerHTML = "";
    console.log(event.target.files);
    for (var i = 0; i < files.length; i++) {
        preview.innerHTML = files[i].name;
    }
}





document.getElementById('produits_ticket_src').addEventListener('change', loadFile);

document.getElementById('produits_manuel_src').addEventListener('change', loadFile);

document.getElementById('produits_images').addEventListener('change', loadFilesImgs);


/*
Recuperation d'une image pour afficher dans le general
event (event) : evenement d'ecoute
*/
function loadFiles(event) {
    let files = event.target.files;
    let preview = document.getElementById("add_img");
    for (var i = 0; i < files.length; i++) {
      var file = files[i];
      var imageType = /^image\//;
  
      if (!imageType.test(file.type)) {
        continue;
      }

      var img = document.createElement("img");
      img.classList.add("obj");
      img.classList.add("img-slide-presentation");
      img.classList.add("drag_img");
      img.id = "img_"+nb_photo_gener;
      img.setAttribute('draggable', true);
      img.file = file;
      preview.appendChild(img);

      var imgDelete = document.createElement("img");
      imgDelete.classList.add("delete_image");
      imgDelete.src = "./../img/icons8-supprimer-pour-toujours-90.svg";
      imgDelete.setAttribute("alt","suprimer la photo");
      imgDelete.setAttribute("title","suprimer la photo");
      imgDelete.id = "delete_img_"+nb_photo_gener;
      preview.appendChild(imgDelete);

      nb_photo_gener++;

      var reader = new FileReader();
      reader.onload = (function(aImg) {
          return function(e) { 
              aImg.src = e.target.result;
            };
        })(img);
      reader.readAsDataURL(file);
    }
    form_delete_click_img();
    allDragDropImg();
}