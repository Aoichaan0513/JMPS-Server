<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isServer($JSON_array['apiKey'])) {
        $pdo = getPDO();
        $st1 = $pdo->query("SELECT * FROM `Punish_GBan` WHERE `UUID` = '" . $JSON_array['uuid'] . "' AND `Active` = " . $JSON_array['active']);
        while ($row = $st1->fetch()) {
            $server = htmlspecialchars($row['Server']);
            if ($JSON_array['server'] == $server) {
                $st2 = $pdo->prepare("UPDATE `Punish_GBan` SET `Active` = 0 WHERE `UUID` = ? AND `Server` = ? AND `Active` = ?");
                $st2->execute(array($JSON_array['uuid'], $JSON_array['server'], $JSON_array['active']));
                echo '{"result": true}';
                return;
            }
            echo '{"result": false, "reason": "You can not release the global ban for different from the punishment the server."}';
            return;
        }
    }
    echo '{"result": false, "reason": "API key or server could not be found."}';
    return;
?>