
for (let i = 0; i < categoriesJson.color.length; i++) {
    if(categoriesJson.color[i] == undefined || categoriesJson.color[i] == "" || 
    categoriesJson.color[i] == "#000000" || categoriesJson.color[i] == "#FFFFFFF") {
        let r = Math.floor(Math.random() * 255);
        let g = Math.floor(Math.random() * 255);
        let b = Math.floor(Math.random() * 255);
        categoriesJson.color[i] = 'rgba('+r+', '+g+', '+b+', 0.7)';
    }
}
function diagramCat(title, id, count = false) {
    let displayCat = categoriesJson.price;
    if(count) {
        displayCat = categoriesJson.count;
    }
    let categories = document.querySelector(id);
    return new Chart(categories, {
        type: "bar",// 'pie'
        data: {
            labels: categoriesJson.name,
            datasets: [{
                data: displayCat,
                backgroundColor: categoriesJson.color
            }]
        },
        options: {
            responsive: false,
            plugins: {
                title: {
                    display: true,
                    text: title,
                    font: {
                        size: 18
                    }
                },
                legend: {
                    display: false,
                    position: 'bottom'
                }
            }
        }
    })
}
diagramCat('les sommes dépensées par catégorie', "#categories-sommes");
diagramCat('Le nombre de produits par catégorie', "#categories-number", true);
