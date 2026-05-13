function searchCar(){

    let key = document.getElementById('search').value;

    if(key == ""){

    document.getElementById('result').innerHTML = "";

    return;
}
    let xhttp = new XMLHttpRequest();
    xhttp.open('GET','../controller/search.php?key=' + key,true);

    xhttp.send();

    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){

            let cars = JSON.parse(this.responseText);

            let output = "";

            for(let i=0; i<cars.length; i++){

                output += `

                <a href="carDetails.php?id=${cars[i].id}">

                    <div>

                        <img src="../asset/upload/${cars[i].image_path}"
                             width="150">

                        <h3>${cars[i].name}</h3>

                        <p>${cars[i].model}</p>

                        <p>${cars[i].price_per_day}</p>

                    </div>

                </a>

                <hr>

                `;
            }

            document.getElementById('result').innerHTML =
            output;
        }
    }
}