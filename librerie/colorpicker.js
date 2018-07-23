var colori =[
    [0,2,1],
    [2,0,-1],
    [2,1,1],
    [1,2,-1],
    [1,0,1],
    [0,1,-1]
];

function color_picker(translation) {
    var container = document.createElement("DIV");
    var pointer = document.createElement("DIV");
    pointer.style.backgroundColor = "rgb(255,0,255)";
    var img = document.createElement("IMG");
    container.className = "box_colorpicker";
    img.src = "../imgs/line.png";
    container.appendChild(img);
    container.appendChild(pointer);
    pointer.onmousedown = dragMouseDown;
    img.onmousedown = pick;
    var pos1 = 0, pos2 = 0;
    function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        pos2 = e.clientX;
        document.onmouseup = closeDragElement;
        document.onmousemove = elementDrag;
    }
    function elementDrag(e) {
        var w = container.offsetWidth;
        var step = w/6;
        e = e || window.event;
        e.preventDefault();
        pos1 = pos2 - e.clientX;
        pos2 = e.clientX;
        l = pointer.offsetLeft - pos1;
        if(l<0 || l>w-pointer.offsetWidth) return;
        pointer.style.left = l + "px";

        l = l+pointer.offsetWidth/2;
        var s = Math.floor(l/step);
        var rest = l/step-s;
        var colore = colori[s];
        var a = [];
        a[colore[0]] = 255;
        if(colore[2]>0){
            a[colore[1]] = 255*rest;
        }else{
            a[colore[1]] = 255-255*rest;
        }
        for (var i = 0; i<3; i++){
            if(!a[i]){
                a[i] = 0;
            }
        }
        pointer.style.backgroundColor = "rgb("+Math.round(a[0])+","+Math.round(a[1])+","+Math.round(a[2])+")";
    }
    function getX(element) {
        var xPosition = 0;
        while(element) {
            xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
            element = element.offsetParent;
        }
        return xPosition;
    }
    function closeDragElement() {
        document.onmouseup = null;
        document.onmousemove = null;
    }
    function pick(e) {
        var w = container.offsetWidth;
        var step = w/6;
        var l = e.clientX-(getX(container)-translation)-pointer.offsetWidth/2;
        pointer.style.left = l+"px";
        var s = Math.floor(l/step);
        var rest = l/step-s;
        var colore = colori[s];
        var a = [];
        a[colore[0]] = 255;
        if(colore[2]>0){
            a[colore[1]] = 255*rest;
        }else{
            a[colore[1]] = 255-255*rest;
        }
        for (var i = 0; i<3; i++){
            if(!a[i]){
                a[i] = 0;
            }
        }
        pointer.style.backgroundColor = "rgb("+Math.round(a[0])+","+Math.round(a[1])+","+Math.round(a[2])+")";;
    }
    function set_color(r,g,b) {
        // todo
    }
    img.click();
    container.set_color = set_color;
    return container;
}