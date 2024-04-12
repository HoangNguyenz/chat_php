
const pswrdField = document.querySelector(".form .field input[type='password']");

toggleBtn = document.querySelector(".form .field i");

toggleBtn.onclick = () => {
    if(pswrdField.type == "password"){
        pswrdField.type = "text";
        toggleBtn.classList.add("active"); //thay doi icon an hien password
    }else {
        pswrdField.type = "password";
        toggleBtn.classList.remove("active"); //thay doi icon an hien password
    }
}