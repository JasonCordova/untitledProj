<?php

    function se($v, $k = null, $default = "", $isEcho = true)
    {
        if (is_array($v) && isset($k) && isset($v[$k])) {
            $returnValue = $v[$k];
        } else if (is_object($v) && isset($k) && isset($v->$k)) {
            $returnValue = $v->$k;
        } else {
            $returnValue = $v;
            //added 07-05-2021 to fix case where $k of $v isn't set
            //this is to kep htmlspecialchars happy
            if (is_array($returnValue) || is_object($returnValue)) {
                $returnValue = $default;
            }
        }
        if (!isset($returnValue)) {
            $returnValue = $default;
        }
        if ($isEcho) {
            //https://www.php.net/manual/en/function.htmlspecialchars.php
            echo htmlspecialchars($returnValue, ENT_QUOTES);
        } else {
            //https://www.php.net/manual/en/function.htmlspecialchars.php
            return htmlspecialchars($returnValue, ENT_QUOTES);
        }
    }

    function loggedIn(){

        return (isset($_SESSION) && isset($_SESSION["user"]));

    }

    function getUsername(){

        if (loggedIn()){

            $username = se($_SESSION["user"], "username", "", false);
            return $username;

        } else {

            return NULL;
            header("Location: login.php");

        }

    }

    function getStatus(){

        return "online";

    }

    function getUserID(){

        if (loggedIn()){

            return se($_SESSION["user"], "id", "", false);

        } else {

            return NULL;

        }

    }

?>