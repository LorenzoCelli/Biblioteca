var search_bar = document.getElementById("search_bar");
function slide_search_bar(element_id) {
    if(search_bar.style.width === "" || search_bar.style.width === "0px"){
        search_bar.style.width = "500px";
    }else{
        search_bar.style.width = "0px";
    }
}

var new_menu = document.getElementById("new_menu");
function slide_new_menu(){
    if(!new_menu.is_open){
        new_menu.style.transform = "translateX(-400px)";
        new_menu.is_open = true;
    }else{
        new_menu.style.transform = "translateX(0)";
        new_menu.is_open = false;
    }
}

var main_menu = document.getElementById("main_container");
function slide_main_menu(){
    if(!main_menu.is_open){
        main_menu.style.transform = "translateX(0)";
        main_menu.is_open = true;
    }else{
        main_menu.style.transform = "translateX(-300px)";
        main_menu.is_open = false;
    }
}

function listalibrerie() {
  var select = document.querySelector('select[name=nome_libreria]');
  var select2 = document.querySelector('select[name=scaffale]');
  var num_scaffali = libreria[select.value];
  select2.innerHTML = "";
  for (var i = 1; i <= num_scaffali; i++) {
    select2.innerHTML += "<option value='"+i+"'>"+i+"</option>";
  }
}
