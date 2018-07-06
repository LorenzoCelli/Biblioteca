var pass = document.getElementById("pass");
var check = document.getElementById("pass_check");
var target = document.getElementById("pass_alarm");
var btn = document.getElementById("register_button");

var email_field =  document.getElementById("email");
var email_msg = document.getElementById("emailmsg");
var usr_field = document.getElementById("usr");
var usr_msg = document.getElementById("usrmsg");

var first_focus = false;

function had_first_focus() {
    first_focus = true;
}

function check_pass(){
    console.log(first_focus);
    var c = pass.value!==check.value;
    btn.disabled = c;
    if(c && first_focus){
        target.style.display = "block";
    }else{
        target.style.display = "none";
    }
}

function wrong_user(){
    usr_msg.style.display="block";
    usr_field.onkeyup = function () {
        if(this.value === uname){
            usr_msg.style.display = "block";
        }else{
            usr_msg.style.display = "none";
        }
    }
}

function wrong_email(){
    email_msg.style.display="block";
    email_field.onkeyup = function () {
        if(this.value === email){
            email_msg.style.display = "block";
        }else{
            email_msg.style.display = "none";
        }
    }
}