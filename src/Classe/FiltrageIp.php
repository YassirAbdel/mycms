<?php

namespace App\Classe;

class FiltrageIp
{
    function ipVerif($ip) {
        $ipDebut = ip2long('192.168.0.0'); 
        $ipFin = ip2long('192.168.255.255');
        $ipAbloquer = ip2long($ip);
        if (($ipAbloquer >= $ipDebut) && ($ipAbloquer <= $ipFin)) {
            $allow = 1;
        }else{
            $allow = 0;
        }
        return $allow;
    }
}
