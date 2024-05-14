window.onload = () => {
    let verified = document.querySelectorAll("[type=checkbox]");
    for (let bouton of verified) {
        bouton.addEventListener("click", function () {
            let xmlhttp = new XMLHttpRequest;
            xmlhttp.open("get", `/admin/users/verified/${this.dataset.id}`)
            xmlhttp.send()
        })
    }
    let selects = document.querySelectorAll(".select-role");
    for (let select of selects) {
        select.addEventListener("change", function () {
            console.log(select.value);
            let xmlhttp = new XMLHttpRequest;
            xmlhttp.open("get", `/admin/users/role/${this.dataset.id}/${select.value}`)
            xmlhttp.send();
        })
    }
}