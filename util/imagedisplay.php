<?php

class imagedisplay {

    public static function display($link) {
        if (!empty($link) && file_exists(ROOT . '/' . $link)) {
            return URL . $link;
        }else{
            return URL. 'public/img/avatar.svg';
        }
    }
    

}
