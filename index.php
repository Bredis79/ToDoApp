<?php
session_start();
$db = new PDO(
    "mysql:host=localhost;dbname=todoapp;charset=utf8",
    "root",
    "",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
);


$chyba = [
    "prihlaseni" => "",
    "register" => "",
    "uzivatel" => "",
];

$username = null;
$password = null;

$error = null;
$editace = false;

// LOGIN
if (array_key_exists("login", $_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validace vstupů
    if (empty($username) || empty($password)) {
        $chyba["prihlaseni"] = "Username and password must be filled.";
    } else {
        // Vyhledání uživatele podle uživatelského jména a hesla
        $dotaz = $db->prepare("SELECT * FROM users WHERE username = ? AND user_password = ?");
        $dotaz->execute([$username, $password]);
        $login = $dotaz->fetch();

        if ($login) {
            // Uživatelské jméno a heslo jsou správné
            $_SESSION["prihlasenyUzivatel"] = $login["username"];
            $_SESSION["user_id"] = $login["id"];
            header("Location: ?");
            exit();
        } else {
            // Špatné uživatelské jméno nebo heslo
            $chyba["prihlaseni"] = "Wrong username or password.";
        }
    }
}

// REGISTRACE
if (array_key_exists("register", $_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // kontrola zda uzivatel už neexistuje
    $dotaz = $db->prepare("SELECT username FROM users WHERE username = ?");
    $dotaz->execute([$username]);
    $existingUser = $dotaz->fetch();

    if ($existingUser) {
        $chyba["uzivatel"] = "This username already exists";
    } else if ($username == "" || $password == "") {                // pokud neni vyplneny jmeno nebo heslo, tak vyskoci chyba
        $chyba["register"] = "Username and password must not be empty";
    } else {                                                        // pokud je vyplnene jmeno a heslo, tak se ulozi do databaze
        $dotaz = $db->prepare("INSERT INTO users (username, user_password) VALUES (?, ?)");
        $dotaz->execute([$username, $password]);
        header("Location: ?");
    }
}
    


// ODHLASENI
if (array_key_exists("odhlasit", $_POST)) {
    unset($_SESSION["prihlasenyUzivatel"]);
    unset($_SESSION["user_id"]);
}

// pokud je prihlaseny uzivatel, tak se zobrazi jeho ukoly
if (array_key_exists("user_id", $_SESSION)) {
    // get values from db
    $dotaz = $db->prepare('SELECT id, ukol FROM ukoly WHERE user_id = ?');
    $dotaz->execute([$_SESSION["user_id"]]);
    $ukoly = $dotaz->fetchAll();

    // zpracovani ADD BUTTON
    if (array_key_exists("vlozit", $_POST)) {
        $ukol = $_POST["ukol"];
       
        // validation
        if (empty($ukol)) {
            $error = "You did not write any task";
        } else {
            // save into database
            // $dotaz = $db->prepare("INSERT INTO ukoly (ukol) VALUES (?)");
            // $dotaz->execute([$ukol]);
            
            $dotaz = $db->prepare("INSERT INTO ukoly SET ukol = ?, user_id = ?");
            $dotaz->execute([$ukol, $_SESSION["user_id"]]);
        }

        header("Location: ?");
        exit();
    }
}


// editace úkolu
if (array_key_exists("edit", $_GET)) {
    $editace = true;
    $editaceId = $_GET["edit"];
}    

// ulozeni po editaci
if (array_key_exists("save", $_GET)) {

    $ukolEditace = $_GET["ukol"];
    $ukolId = $_GET["save"];

    $dotaz = $db->prepare("UPDATE ukoly SET ukol = ? WHERE id = ?");
    $dotaz->execute([$ukolEditace, $ukolId]);

    header("Location: ?");
    exit();
}

// odstranění úkolu
if (array_key_exists("delete", $_GET)) {
    $deleteId = $_GET["delete"];

    $dotaz = $db->prepare("DELETE FROM ukoly WHERE id = ?");
    $dotaz->execute([$deleteId]);

    header("Location: ?");
    exit();
}

?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/task.css">
    <link rel="stylesheet" href="css/queries.css">
    <link rel="stylesheet" href="css/singIn.css">
    <link rel="stylesheet" href="css/register.css">
    <!--<link rel="stylesheet" href="fontawesome/css/all.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <title>TODO App</title>
</head>
<body>
    
<?php
    // Pokud existuje klíč "register", zobrazi se register.php a vypíše se obsah $_GET
    if (array_key_exists("singUp", $_GET)) {
        require "register.php";
    } 

    // pokud není správné heslo a jméno, tak se zobrazí formulář
    if(array_key_exists("prihlasenyUzivatel", $_SESSION) == false) {
        require "login.php";
        } else {
            // pokud se shoduje heslo a jméno zobrazí se ukoly
            require "tasks.php";
    }

?>


</body>
</html>
