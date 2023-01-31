function validasi() {
    var username = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    if (username != "" && password != "") {
        return true;
    }else{
        alert("Email dan Password Tidak Boleh Kosong!")
        return false;
    }
}