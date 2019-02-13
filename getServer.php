<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isset($JSON_array['apiKey'])) {
        if (isServer($JSON_array['apiKey'])) {
            $servers = json_decode(getServer($JSON_array['apiKey']), true);
            if ($servers['result'] == true) {
                echo '{"result": true, "id": "' . $servers['id'] . '", "name": "' . $servers['name'] . '", "address": "' . $servers['address'] . '", "owner": "' . $servers['owner'] . '"}';
                return;
            }
            echo '{"result": false, "reason": "API key or server could not be found."}';
            return;
        }
        echo '{"result": false, "reason": "API key or server could not be found."}';
        return;
    } else if (isset($JSON_array['id'])) {
        $pdo = getPDO();
        $st = $pdo->query("SELECT * FROM `Server` WHERE `ID` = '" . $JSON_array['id'] . "'");
        while ($row = $st->fetch()) {
            $id = htmlspecialchars($row['ID']);
            $name = htmlspecialchars($row['Name']);
            $address = htmlspecialchars($row['Address']);
            $owner = htmlspecialchars($row['Owner']);
            echo '{"result": true, "id": "' . $id . '", "name": "' . $name . '", "address": "' . $address . '", "owner": "' . $owner . '"}';
            return;
        }
        echo '{"result": false, "reason": "API key or server could not be found."}';
        return;
    }
?>