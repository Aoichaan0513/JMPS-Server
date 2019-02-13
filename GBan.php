<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isServer($JSON_array['apiKey'])) {
        $pdo = getPDO();
        $st = $pdo->prepare("INSERT INTO `Punish_GBan` (`ID`, `Name`, `UUID`, `Reason`, `ByName`, `ByUUID`, `Server`, `Active`) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $st->execute(array(makeRandStr(10), $JSON_array['name'], $JSON_array['uuid'], $JSON_array['reason'], $JSON_array['byName'], $JSON_array['byUUID'], $JSON_array['server'], $JSON_array['active']));
        echo '{"result": true}';
        return;
    }
    echo '{"result": false, "reason": "API key or server could not be found."}';
    return;
?>