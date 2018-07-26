var amici = document.getElementsByClassName("menu_amici")[0];
function dropDown() {
  if(amici.style.height == "0px" || amici.style.height == "") {
    document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(0deg)";
    document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[0].style.marginBottom = "120px";
    document.getElementsByClassName("title")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[1].style.marginBottom = "120px";
    document.getElementsByClassName("title")[1].style.transition = "all 0.4s";
    amici.style.height = "85px";
    amici.style.transition = "all 0.4s";
  } else {
    document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(90deg)";
    document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[0].style.marginBottom = "0px";
    document.getElementsByClassName("title")[1].style.marginBottom = "0px";
    amici.style.height = "0px";
  }
}
function menuScelto(opzione,nascondi) {
  amici.style.height = "0px";
  document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(90deg)";
  document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
  document.getElementsByClassName("title")[0].style.marginBottom = "10px";
  document.getElementsByClassName("title")[1].style.marginBottom = "10px";
  document.getElementsByClassName(nascondi)[0].style.display = "none";
  document.getElementsByClassName(opzione)[0].style.display = "block";
}
