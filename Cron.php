<?php
    require "Utils.php";

    $pdo = getPDO();
    $st = $pdo->query("SELECT * FROM `Punish_TBan` WHERE `Active` = 1");
    while ($row = $st->fetch()) {
        $id = htmlspecialchars($row['ID']);
        $date = htmlspecialchars($row['Date']);
        $endDate = htmlspecialchars($row['EndDate']);

        if ((formatStamp((new DateTime($date))->format('U')) + $endDate) < formatStamp(getCurrentDate()->format('U'))) {
            execute($id);
            continue;
        } else {
            continue;
        }
    }

    function getCurrentDate() {
        $dt = new DateTime();
        return $dt;
    }

    function execute($id) {
        $pdo = getPDO();
        $st = $pdo->prepare("UPDATE `Punish_TBan` SET `Active` = 0 WHERE `ID` = ?");
        $st->execute(array($id));
    }
?>