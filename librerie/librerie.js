var s_counter = document.querySelector("input[name=n_scaffali]");
var box_scaffali = document.getElementsByClassName("box_scaffali")[0];

function nuovo_scaffale() {
    if(s_counter.value>249) return;
    s_counter.value ++;
    var sc = scaffale();
    console.log();
    box_scaffali.appendChild(sc);
    sc.style.height = "0px";
    sc.style.backgroundColor = "#dedede";
    window.requestAnimationFrame(function (time) {
        sc.style.height = "0px";
        sc.style.backgroundColor = "#dedede";
        window.requestAnimationFrame(function (time1) {
            sc.style.height = "70px";
            sc.style.backgroundColor = "white";
        });
    });
    check();
}
function rimuovi_scaffale() {
    if(s_counter.value<2) return;
    s_counter.value --;
    sc = box_scaffali.childNodes[box_scaffali.childNodes.length-1];
    window.requestAnimationFrame(function (time) {
        sc.style.height = "70px";
        sc.style.backgroundColor = "white";
        window.requestAnimationFrame(function (time1) {
            sc.style.height = "0px";
            sc.style.backgroundColor = "#dedede";
            window.setTimeout(function (time2) {
                box_scaffali.removeChild(sc);
            }, 150);
        });
    });
}
function check() {
    if(parseInt(s_counter.value) !== (box_scaffali.childNodes.length+1)){
        nuovi_scaffali();
    }
}
function scaffale() {
    var div = document.createElement("DIV");
    div.className = "scaffale";
    return div;
}
function nuovi_scaffali() {
  var count = s_counter.value;
  if(count>250 || count<1) return;
  box_scaffali.innerHTML = "";
  for (var i = 0; i < count-1; i++) {
    box_scaffali.appendChild(scaffale());
  }
  contatoreScaffali = count;
}
function reset_new_book() {
    new_menu.querySelector('input[name=nome]').value = "";
    new_menu.querySelector('input[name=descr]').value = "";
    new_menu.querySelector('input[name=n_scaffali]').value = 1;
    box_scaffali.innerHTML = "";
    slide_new_menu()
}
function modifica_libreria() {
    var info_boxes = info_menu.getElementsByClassName("info_box");
    console.log(info_boxes);
    for(var i=0; i<info_boxes.length; i++){
        var info_box = info_boxes[i];
        info_box.style.display = "block";
        var info_p = info_box.getElementsByClassName("info_p")[0];
        var input = document.createElement("input");
        input.value = info_p.innerHTML;
        var info_tooltip = info_box.getElementsByClassName("info_tooltip")[0];
        input.name = info_tooltip.innerHTML;
        if(info_tooltip.innerHTML === "colore etichetta"){
            input = color_picker(500);
        }
        if(info_tooltip.innerHTML === "numero scaffali"){
            input.type = "number";
        }
        info_box.replaceChild(input, info_p);
        info_tooltip.style.display = "block";
    }
    info_menu.getElementsByClassName("to_hide")[0].style.display = "none";
    info_menu.getElementsByClassName("to_show")[0].style.display = "block";
}

var container = document.getElementsByClassName("box_colorpicker")[0];
container.parentElement.replaceChild(color_picker(400),container);

