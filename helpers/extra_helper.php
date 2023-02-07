<?php
    function get_post($key){
        $rel='';

        if(isset($_POST[$key])){
            $rel=trim($_POST[$key]);
        }
        return $rel;
    }


    function check_words($word,$minlength,$maxlength){
        $len = mb_strlen($word);
        if($len >= $minlength && $len <= $maxlength){
            return TRUE;
        }else{
            return FALSE;
        }
    }