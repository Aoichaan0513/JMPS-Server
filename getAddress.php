<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isServer($JSON_array['apiKey'])) {
        $pdo = getPDO();
        $st = $pdo->query("SELECT * FROM `Address` WHERE (`Date` = (select max(`Date`) from `Address`)) and `UUID` = '" . $JSON_array['uuid'] . "' ORDER BY Date DESC LIMIT 1");
        while ($row = $st->fetch()) {
            $uuid = htmlspecialchars($row['UUID']);
            $ip = htmlspecialchars($row['IP']);
            $date = htmlspecialchars($row['Date']);
            echo '{"result": true, "uuid": "' . $uuid . '", "ip": "' . $ip . '", "date": "' . $date . '"}';
            return;
        }
        echo '{"result": false, "reason": "Address history not found."}';
        return;
    }
    echo '{"result": false, "reason": "API key or server could not be found."}';
    return;
?>