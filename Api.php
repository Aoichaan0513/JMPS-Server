<?php
    require "Utils.php";

    $JSON_string = file_get_contents('php://input');
    $JSON_array = json_decode($JSON_string, true);

    header("Content-Type: application/json; charset=utf-8");

    if (isServer($JSON_array['apiKey'])) {
        $servers = json_decode(getServer($JSON_array['apiKey']), true);
        if ($servers['result'] == true) {
            echo '{"result": true, "name": "' . $servers['name'] . '"}';
            return;
        }
        echo '{"result": false, "reason": "API key or server could not be found."}';
        return;
    }
    echo '{"result": false, "reason": "API key or server could not be found."}';
    return;
?>