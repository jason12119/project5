<?php

class db_connect
{
    const host = 'localhost';
    const user = 'root';
    const pass = 'root';
    const db_name = 'project5';
    var $prefix = 'project5_';

    // const host = 'mysql01.srv.webcloud.cz';
    // const user = 'usr706425';
    // const pass = 'c761966d';
    // const db_name = 'prestissimo_cz_prestis';
    // var $prefix = 'amp_';

    function db()
    {
        ($connect = mysqli_connect(
            self::host,
            self::user,
            self::pass,
            self::db_name
        )) or die('Could not connect to database!');
        $connect->set_charset('utf8');
        $connect->query("SET SESSION sql_mode=''");
        return $connect;
    }

    // Ochrana proti sql injection
    function sqlInjection($string)
    {
        return mysqli_real_escape_string($this->db(), $string);
    }
}

?>
