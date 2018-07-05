function scroll_to_right(element_id) {
    var element = document.getElementById(element_id);
    element.style.transform = "translateX(-66.66%)";
}
function scroll_to_center(element_id) {
    var element = document.getElementById(element_id);
    element.style.transform = "translateX(-33.33%)";
}
<<<<<<< HEAD
function scroll_to_left(element_id) {
    var element = document.getElementById(element_id);
    element.style.transform = "translateX(0)";
}
function checkPassword() {
  var first_password = document.getElementById('password_confirm').value;
  var second_password = document.getElementById('password_confirm_check').value;
  if(first_password == second_password) {
    document.getElementById('message').innerHTML = '';
    document.getElementById('register_button').disabled = false;
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Password non corrispondenti!';
    document.getElementById('register_button').disabled = true;
  }
  if (first_password == "" || second_password == ""){
    document.getElementById('message').innerHTML = "";
  }
=======

function wrong_user(){
    usr_msg.style.display="block";
    usr_field.onkeyup = function () {
        if(this.value === uname){
            usr_msg.style.display = "block";
        }else{
            usr_msg.style.display = "none";
        }
    }
>>>>>>> 369c518628cc301cf412c07cdce112d36ebd2565
}
