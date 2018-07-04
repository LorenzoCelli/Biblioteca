function show_hide(element_id) {
    element = document.getElementById(element_id);
    if(element.style.width == "" || element.style.width == "0px"){
        element.style.width = "500px";
    }else{
        element.style.width = "0px";
    }
}