for (let i = 0; i < catColors.length; i++) {
    if(catColors[i] == undefined || catColors[i] == "" || catColors[i] == "#000000" || catColors[i] == "#FFFFFFF") {
        let r = Math.floor(Math.random() * 255);
        let g = Math.floor(Math.random() * 255);
        let b = Math.floor(Math.random() * 255);
        catColors[i] = 'rgba('+r+', '+g+', '+b+', 0.7)';
    }
}
let categories = document.querySelector("#categories-sommes");
let categGraph = new Chart(categories, {
    type: "pie",
    data: {
        labels: catName,
        datasets: [{
            data: catPrice,
            backgroundColor: catColors
        }]
    },
    options: {
        responsive: false,
        plugins: {
            title: {
                display: true,
                text: 'les sommes dépensées par catégorie',
                font: {
                    size: 18
                }
            },
            legend: {
                position: 'bottom'
            }
        }
    }
})
let categoriesNumb = document.querySelector("#categories-number");
let categGraphNum = new Chart(categoriesNumb, {
    type: "pie",
    data: {
        labels: catName,
        datasets: [{
            data: catCount,
            backgroundColor: catColors
        }]
    },
    options: {
        responsive: false,
        plugins: {
            title: {
                display: true,
                text: 'Le nombre de produits par catégorie',
                font: {
                    size: 18
                }
            },
            legend: {
                position: 'bottom'
            }
        }
    }
})