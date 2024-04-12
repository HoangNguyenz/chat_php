

const form = document.querySelector(".signup form");
continueBtn = form.querySelector(".button input");
errorText = form.querySelector(".error-txt");


form.onsubmit = (e) => {
    e.preventDefault();

}


continueBtn.onclick = () => {
    //Ajax
    let xhr = new XMLHttpRequest(); //creating xml object
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200) {
                let data = xhr.response; //xhr.response give us response of that passed url
                if(data == "success"){
                   location.href = "users.php";
                }else {
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }

    //send the form data through Ajax to php
    let formData = new FormData(form); //creating form data object
    xhr.send(formData); //sending the form data to  php
}