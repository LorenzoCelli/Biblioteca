<?php

function avatar($id_avatar){
  switch ($id_avatar) {
    case 0:
      return "../imgs/usericon.svg";
    case 1:
      return "../imgs/avatars/1.png";
    case 2:
      return "../imgs/avatars/2.png";
    case 3:
      return "../imgs/avatars/3.png";
    case 4:
      return "../imgs/avatars/4.png";
    case 5:
      return "../imgs/avatars/5.png";
    case 6:
      return "../imgs/avatars/6.png";
  }
}

?>