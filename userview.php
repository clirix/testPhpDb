<?php
use Module\User\User;
use Module\User\UserEntity;

define('MODULE_PATH', realpath(dirname(__FILE__).'/module'));
require_once(MODULE_PATH.'/User/User.php');

// UserObjekt aufrufen
$user = new User();
$msg = '';
if (isset($_POST) && !empty($_POST['FirstName'])) {
    $newUser = new UserEntity();
    $newUser->setEmail($_POST['Email']);
    $newUser->setFirstName($_POST['FirstName']);
    $newUser->setLastName($_POST['LastName']);
    $msg = $user->setUser($newUser);
}

$users = $user->getUserCollection();
$userTableRows ='';

foreach($users as $user){
    $userTableRows .= '<tr>';
    $userTableRows .= '<td>' . htmlspecialchars($user->getId()) . '</td>';
    $userTableRows .= '<td>' . htmlspecialchars($user->getFirstName()) . '</td>';
    $userTableRows .= '<td>' . htmlspecialchars($user->getLastName()) . '</td>';
    $userTableRows .= '<td>' . htmlspecialchars($user->getEmail()) . '</td>';
    $userTableRows .= '</tr>';
}

echo <<<HTML
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">

    </head>
    <body>
        <h2> User Eingabe </h2>
        <p>
        <form method="POST" action=" /userview.php">
            <p>
                <label for="FirstName">Vorname</label>
                <input type="text" name="FirstName" size="40">
            </p><p>
                <label for="LastName">Nachname</label>
                <input type="text" name="LastName" size="40">
            </p><p>
                <label for="Email">E-Mail</label>
                <input type="text" name="Email" size="40">
            </p>
            <input type="submit" name="Submit" value="Senden">
        </form>
            $msg
        </p>
        <h2>
            User Ausgabe
        </h2>
        <p>
            <table>
                <thead>
                    <td>Id</td>
                    <td>Vorname</td>
                    <td>Nachname</td>
                    <td>Email</td>
                </thead>
                $userTableRows
            </table>

        </p>
    </body>
HTML;

