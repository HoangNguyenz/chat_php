const searchBar = document.querySelector(".users .search input");
searchBtn = document.querySelector(".users .search button");
usersList = document.querySelector(".users .users-list");



searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
}

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;

    //adding active class when user begin searching and only run setInterval if there is no active class
    if(searchTerm != "") {
        searchBar.classList.add("active");
    }else {
        searchBar.classList.remove("active");
    }

     //Ajax
     let xhr = new XMLHttpRequest(); //creating xml object

     //get method to receive data (not send)
     xhr.open("POST", "php/search.php", true);
     xhr.onload = () => {
         if(xhr.readyState === XMLHttpRequest.DONE){
             if(xhr.status === 200) {
                 let data = xhr.response; //xhr.response give us response of that passed url
                 usersList.innerHTML = data;
             }
         }
     }
     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
     xhr.send("searchTerm=" + searchTerm); //sending user search term to php file with ajax
}


setInterval(() => {
     //Ajax
     let xhr = new XMLHttpRequest(); //creating xml object

     //get method to receive data (not send)
     xhr.open("GET", "php/users.php", true);
     xhr.onload = () => {
         if(xhr.readyState === XMLHttpRequest.DONE){
             if(xhr.status === 200) {
                 let data = xhr.response; //xhr.response give us response of that passed url
                 if(!searchBar.classList.contains("active")) { //searchBar ko có active class thì mới chạy, tránh chạy lần ajax
                    usersList.innerHTML = data;
                 }
             }
         }
     }
     xhr.send();
}, 500); // this function will reun frequently agter 500ms

// users.js
document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các phần tử a trong class content
    const userLinks = document.querySelectorAll('.content a');

    // Lặp qua mỗi phần tử và thêm sự kiện click
    userLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            // Ngăn chặn hành vi mặc định của liên kết
            event.preventDefault();
            // Chuyển hướng đến đường dẫn của liên kết
            window.location.href = link.href;
        });
    });
});
