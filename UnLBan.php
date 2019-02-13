<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isServer($JSON_array['apiKey'])) {
        $pdo = getPDO();
        $st = $pdo->prepare("UPDATE `Punish_LBan` SET `Active` = 0 WHERE `UUID` = ? AND `Server` = ? AND `Active` = ?");
        $st->execute(array($JSON_array['uuid'], $JSON_array['server'], $JSON_array['active']));
        echo '{"result": true}';
        return;
    }
    echo '{"result": false, "reason": "API key or server could not be found."}';
    return;
?>