<?php
require_once 'Db.php';
$db = new Db();
$invoices = $db->getInvoices();
$receivers = $db->getRecievers();
$mechanics = $db->getMechanics();
$workCodes = $db->getWorks();
$partCodes = $db->getParts();


if ($_GET['action'] == 'comeback') {
    header('Location: invoices.php');
}

if ($_GET['action'] == 'add-invoice') {
    $db->addInvoice($_POST['receiver_code'], $_POST['mechanic_code'], $_POST['work_code'], $_POST['part_code'], $_POST['price']);
    header('Location: invoices.php');
}

if ($_GET['action'] == 'edit-invoice') {
    $db->editInvoice($_GET['code'], $_POST['receiver_code'], $_POST['mechanic_code'], $_POST['work_code'], $_POST['part_code'], $_POST['price']);
    header('Location: invoices.php');
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
    <title>Add/edit invoice page</title>
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
    <form action="?action=<?=(empty($_GET) ? "add" : "edit")?>-invoice<?=(empty($_GET) ? "" : "&code=" . $_GET['code'] ."")?>" method="post">
        <h4>Code is <?=(empty($_GET) ? "none" : $_GET['code'])?></h4>
        <div>
            <label for="receiver_code">Виберіть приймаючого авто:</label>
            <select name="receiver_code">
                <? foreach($receivers as $receiver): ?>
                    <option value="<?=$receiver['code']?>"
                        <?php if ($receiver['code'] == $_GET['receiver_code']) echo ' selected="selected"'; ?>>
                        <?=$receiver['surname'] . " " . $receiver['name'] . " " . $receiver['father_name']?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div>
            <label for="mechanic_code">Виберіть механіка авто:</label>
            <select name="mechanic_code">
                <? foreach($mechanics as $mechanic): ?>
                    <option value="<?=$mechanic['code']?>"<?php if ($mechanic['code'] == $_GET['mechanic_code']) echo ' selected="selected"'; ?>>
                        <?=$mechanic['surname'] . " " . $mechanic['name'] . " " . $mechanic['father_name']?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div>
            <label for="work_code">Виберіть роботу над авто:</label>
            <select name="work_code">
                <? foreach($workCodes as $works): ?>
                    <option value="<?=$works['code']?>"<?php if ($works['code'] == $_GET['work_code']) echo ' selected="selected"'; ?>>
                        <?=$works['type']?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div>
            <label for="part_code">Виберіть запчастину авто:</label>
            <select name="part_code">
                <? foreach($partCodes as $parts): ?>
                    <option value="<?=$parts['code']?>"<?php if ($parts['code'] == $_GET['part_code']) echo ' selected="selected"'; ?>>
                        <?=$parts['name']?></option>
                <? endforeach; ?>
            </select>
        </div>
        <label for="price">Вкажіть ціну за послуги:</label>
        <input type="number" class="form-control" name="price" value="<?=$_GET['price']?>">
        <button type="submit" class="btn btn-success btn-lg">Зберігти</button>
    </form>
</div>
</body>