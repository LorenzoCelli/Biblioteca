function scroll_to_right(element_id) {
    var element = document.getElementById(element_id);
    element.style.transform = "translateX(-66.66%)";
}
function scroll_to_center(element_id) {
    var element = document.getElementById(element_id);
    element.style.transform = "translateX(-33.33%)";
}
function scroll_to_left(element_id) {
    var element = document.getElementById(element_id);
    element.style.transform = "translateX(0)";
    console.log("ciao");
}