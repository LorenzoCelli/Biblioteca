var search_bar = document.getElementById("search_bar");

function slide_search_bar() {
    if (search_bar.style.width === "" || search_bar.style.width === "0px") {
        search_bar.style.width = "500px";
    } else {
        search_bar.style.width = "0px";
    }
}

var little_menu = document.getElementById("little_menu_box");

function show_little_menu() {
    if (little_menu.style.height === "" || little_menu.style.height === "0px") {
        little_menu.style.display = "block";
        little_menu.style.height = "auto";
    } else {
        little_menu.style.display = "none";
        little_menu.style.height = "0px";
    }
}

var menu_account = document.getElementById("menu_account");

function show_menu_account() {
    if (menu_account.style.display === "" || menu_account.style.display === "none") {
        menu_account.style.display = "block";
    } else {
        menu_account.style.display = "none";
    }
}

var new_menu = document.getElementById("new_menu");

function slide_new_menu() {
    if (!new_menu.is_open) {
        close_info_menu();
        new_menu.style.transform = "translateX(-400px)";
        new_menu.is_open = true;
    } else {
        new_menu.style.transform = "translateX(0)";
        new_menu.is_open = false;
    }
}

var main_menu = document.getElementById("main_container");

function slide_main_menu() {
    if (!main_menu.is_open) {
        main_menu.style.transform = "translateX(0)";
        main_menu.is_open = true;
    } else {
        main_menu.style.transform = "translateX(-300px)";
        main_menu.is_open = false;
    }
}