function show_hide(element_id) {
    var element = document.getElementById(element_id);
    if(element.style.width === "" || element.style.width === "0px"){
        element.style.width = "500px";
    }else{
        element.style.width = "0px";
    }
}
function slide_left(element_id){
    var element = document.getElementById(element_id);
    if(!element.is_open){
        element.style.transform = "translateX(-400px)";
        element.is_open = true;
    }else{
        element.style.transform = "translateX(0)";
        element.is_open = false;
    }
}
function slide_right(element_id){
    var element = document.getElementById(element_id);
    if(!element.is_open){
        element.style.transform = "translateX(0)";
        element.is_open = true;
    }else{
        element.style.transform = "translateX(-300px)";
        element.is_open = false;
    }
}
function ingrandisci(container) {
  container.style.width = "1000px";
  container.style.height = "200px";
  container.getElementsByClassName("book_info")[0].style.display = "inline-block";
}
function changee() {
  var select = document.querySelector('select[name=nome_libreria]');
  var select2 = document.querySelector('select[name=scaffale]');
  var num_scaffali = libreria[select.value];
  select2.innerHTML = "";
  for (var i = 1; i <= num_scaffali; i++) {
    select2.innerHTML += "<option value='"+i+"'>"+i+"</option>";
  }
}
