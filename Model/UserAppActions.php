<?php
require_once 'UserActions.php';
require_once 'logincredentials.php';

function RejectRegApplication($regusername, $updater) {
    $results = FindRegApplicationByUsername($regusername);
    $id = $results[0];
    UpdateRegApplication($updater, 0, $id);
    echo "Reg rejected";
}

function CreatingNewUser($username, $updater) {
    // Find the user application string first
    $results = FindRegApplicationByUsername($username);
    $id = $results[0];
    InsertIntoUserTable($results);
    UpdateRegApplication($updater, 1, $id);
}

