<?php
require_once 'Db.php';

$db = new Db();
$mechanics = $db->getMechanics();

if ($_GET['action'] == 'comeback') {
    header('Location: index.php');
}

if ($_GET['action'] == 'add-mechanic') {
    $db->addMechanic($_POST['surname'], $_POST['name'], $_POST['father_name'], $_POST['salary_level'], $_POST['salary']);
    header('Location: index.php');
}

if ($_GET['action'] == 'edit-mechanic') {
    $db->editMechanic($_GET['code'], $_POST['surname'], $_POST['name'], $_POST['father_name'], $_POST['salary_level'], $_POST['salary']);
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <title>Add/edit mechanics page</title>
    <style>
        .content {
            width: 600px;
            margin: 15px auto 0;
        }
        h1 {
            margin-bottom: 15px;
        }
        input, select {
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="content">
        <a href="?action=comeback"><button type="button" class="btn btn-primary">Повернутись назад</button></a>
        <form action="?action=<?=(empty($_GET) ? "add" : "edit")?>-mechanic<?=(empty($_GET) ? "" : "&code=" . $_GET['code'] ."")?>" method="post">
            <h4>Code is <?=(empty($_GET) ? "none" : $_GET['code'])?></h4>
            <input type="text" class="form-control" name="surname" value="<?=$_GET['surname']?>">
            <input type="text" class="form-control" name="name" value="<?=$_GET['name']?>">
            <input type="text" class="form-control" name="father_name" value="<?=$_GET['father_name']?>">
            <input type="text" class="form-control" name="salary_level" value="<?=$_GET['salary_level']?>">
            <input type="number" class="form-control" name="salary" value="<?=$_GET['salary']?>">
            <button type="submit" class="btn btn-success btn-lg">Зберігти</button>
        </form>
    </div>
</body>