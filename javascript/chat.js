

const form = document.querySelector(".typing-area");
inputField = form.querySelector(".input-field");
sendBtn = form.querySelector("button");
chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault();
}



sendBtn.onclick = () => {
     //Ajax
     let xhr = new XMLHttpRequest(); //creating xml object
     xhr.open("POST", "php/insert-chat.php", true);
     xhr.onload = () => {
         if(xhr.readyState === XMLHttpRequest.DONE){
             if(xhr.status === 200) {
                inputField.value = ""; //after message inserted into datbase ==> leave blank input field
                scrollToBottom();
             }
         }
     }
 
     //send the form data through Ajax to php
     let formData = new FormData(form); //creating form data object
     xhr.send(formData); //sending the form data to  php
}



// Khi con trỏ chuột di chuyển vào vùng của phần tử có id là chatBox, một sự kiện mouseenter được kích hoạt.
chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

// Khi con trỏ chuột rời khỏi vùng của phần tử có id là chatBox, sự kiện mouseleave được kích hoạt
chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}



//dynamic message
setInterval(() => {
    //Ajax
    let xhr = new XMLHttpRequest(); //creating xml object

    //get method to receive data (not send)
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200) {
                let data = xhr.response; //xhr.response give us response of that passed url
                   chatBox.innerHTML = data;
                   if(!chatBox.classList.contains("active")){ //ko có class active thì mới scroll to bottom automatically
                        scrollToBottom();
                   }
            }
        }
    }
     //send the form data through Ajax to php
     let formData = new FormData(form); //creating form data object
     xhr.send(formData); //sending the form data to  php
}, 500); // this function will reun frequently agter 500ms



//auto scroll chat box to bottom
function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}