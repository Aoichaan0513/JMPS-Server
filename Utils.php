<?php
    function getPDO() {
        $pdo = new PDO("mysql:dbname=JMPS_Dev;host=incha.work", "JMPS_Dev", "devPasswd");
        // $pdo = new PDO("mysql:dbname=JMPS", "JMPS", "jmpsPasswd");
        return $pdo;
    }

    function isServer($apiKey) {
        $pdo = getPDO();
        $st = $pdo->query("SELECT * FROM `Server` WHERE `APIKey` = '" . $apiKey . "'");
        if ($st->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function getServer($apiKey) {
        $pdo = getPDO();
        $st = $pdo->query("SELECT * FROM `Server` WHERE `APIKey` = '" . $apiKey . "'");
        while ($row = $st->fetch()) {
            if ($apiKey == htmlspecialchars($row['APIKey'])) {
                $id = htmlspecialchars($row['ID']);
                $name = htmlspecialchars($row['Name']);
                $address = htmlspecialchars($row['Address']);
                $owner = htmlspecialchars($row['Owner']);
                return '{"result": true, "id": "' . $id . '", "name": "' . $name . '", "address": "' . $address . '", "owner": "' . $owner . '"}';
            }
        }
        return '{"result": false, "reason": "API key or server could not be found."}';
    }

    function formatStamp($i) {
        return $i + 4;
    }

    function makeRandStr($length) {
        $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        $r_str = null;
        for ($i = 0; $i < $length; $i++) {
            $r_str .= $str[rand(0, count($str) - 1)];
        }
        return $r_str;
    }
?>