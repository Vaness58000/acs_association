function colorDiag(color) {
    if(color == undefined || color == "" || 
    color == "#000000" || color == "#FFFFFFF") {
        let r = Math.floor(Math.random() * 255);
        let g = Math.floor(Math.random() * 255);
        let b = Math.floor(Math.random() * 255);
        return 'rgba('+r+', '+g+', '+b+', 0.7)';
    }
    return color;
}
for (let i = 0; i < categoriesJson.color.length; i++) {
    categoriesJson.color[i] = colorDiag(categoriesJson.color[i]);
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



function diagramDateCat(title, id, produitDataJson) {
    for (let i = 0; i < produitDataJson.datas.length; i++) {
        for (let j = 0; j < produitDataJson.datas[i].length; j++) {
            produitDataJson.datas[i][j].borderColor = colorDiag(produitDataJson.datas[i][j].borderColor);
        } 
    }
    let produitsCount = document.querySelector(id);
    return new Chart(produitsCount, {
        type: "line",
        data: {
            labels: produitDataJson.date[0],
            datasets: produitDataJson.datas[0]
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
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    min: 0,
                }
            }
        }
    })
     
}

diagramDateCat("le nombre des produits", "#produitsCount", produitsJson);
diagramDateCat("le prix des produits", "#produitsCount2", produitsJson2);
