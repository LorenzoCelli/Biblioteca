var pass_id = "pass";
var check_id = "pass_check";
var target = "pass_alarm";
var btn = "register_button";

function check_pass(){
    var pass = document.getElementById(pass_id).value;
    var check = document.getElementById(check_id).value;
    var c = pass!==check;
    document.getElementById(btn).disabled = c;
    if(c){
        document.getElementById(target).style.display = "block";
    }else{
        document.getElementById(target).style.display = "none";
    }
}