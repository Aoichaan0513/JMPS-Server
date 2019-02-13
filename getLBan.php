<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isServer($JSON_array['apiKey'])) {
        $pdo = getPDO();
        $st = $pdo->query("SELECT * FROM `Punish_LBan` WHERE `UUID` = '" . $JSON_array['uuid'] . "' AND `Server` = '" . $JSON_array['server'] . "' AND `Active` = " . $JSON_array['active']);
        while ($row = $st->fetch()) {
            $id = htmlspecialchars($row['ID']);
            $name = htmlspecialchars($row['Name']);
            $reason = htmlspecialchars($row['Reason']);
            $by = htmlspecialchars($row['ByName']);
            echo '{"result": true, "id": "' . $id . '", "name": "' . $name . '", "reason": "' . $reason . '", "by": "' . $by . '"}';
            return;
        }
        echo '{"result": false, "reason": "Local banned history not found."}';
        return;
    }
    echo '{"result": false, "reason": "API key or server could not be found."}';
    return;
?>