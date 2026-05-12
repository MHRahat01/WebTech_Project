function validate(){

    let name = document.getElementById('name').value;
    let password = document.getElementById('password').value;

    if(name == ""){
        alert("Name required");
        return false;
    }

    if(password.length < 8){
        alert("Password must be 8 characters");
        return false;
    }

    return true;
}