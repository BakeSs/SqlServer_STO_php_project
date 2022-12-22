<?php
require_once 'Db.php';

$db = new Db();
$mechanics = $db->getMechanics();
$mostValuableMech = $db->getMostValuableMech();

if ($_GET['action'] == 'invoices') {
    header('Location: invoices.php');
}

if ($_GET['action'] == 'delete-mechanic') {
  $db->deleteMechanic($_GET['code']);
  header('Location: index.php');
}

if ($_GET['action'] == 'edit-mechanic-form') {
  $mechanic = $db->getMechanic($_GET['code'])[0];
  header('Location: mechanic_add_edit.php?code=' . $mechanic['code'] .
      "&surname=" . $mechanic['surname'] . "&name=" . $mechanic['name'] . "&father_name=" .
      $mechanic['father_name'] . "&salary_level=" . $mechanic['salary_level'] . "&salary=" .
      $mechanic['salary']);
}

if ($_GET['action'] == 'add-mechanic-form') {
    header('Location: mechanic_add_edit.php');
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
    <title>Mechanics list</title>
  <style>
    .content {
      width: 600px;
      margin: 15px auto 0;
    }
    h1 {
      margin-bottom: 15px;
    }
    input,
    select {
      margin-bottom: 10px;
    }
    form, table {margin-bottom: 10px;
        margin-top: 5px}
  </style>
</head>
<body>
  <div class="content">
      <a href="?action=invoices"><button type="button" class="btn btn-primary">Invoices</button></a>
      <h1>Таблиця Mechanics</h1>
      <h3>Найрезультативніший механік під номером <?=$mostValuableMech['code']?></h3>
      <h4>Його прізвище <?=$mostValuableMech['surname']?>, а ім'я <?=$mostValuableMech['name']?></h4>
      <br/>
      <h3>Введіть прізвище, ім'я або по-батькові механіка для пошуку</h3>
      <form method="post">
          <input type="text" class="form-control" name="pib" value="<?=$_POST['pib']?>">
          <button type="submit" class="btn btn-success btn-lg">Знайти механіка</button>
      </form>
      <a href="?action=add-mechanic-form"><button type="button" class="btn btn-primary">Додати механіка</button></a>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">code</th>
          <th scope="col">surname</th>
          <th scope="col">name</th>
          <th scope="col">father_name</th>
          <th scope="col">salary_level</th>
          <th scope="col">salary</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <? foreach($mechanics as $mechanic): ?>
        <?
            $pib = " " . $mechanic['surname']. " " . $mechanic['name'] . " " . $mechanic['father_name'] . " ";
            if(!empty($_POST['pib'])){
                if (!strpos($pib, $_POST['pib']))
                    continue;
            }
            ?>
        <tr>
          <th scope="row"><?=$mechanic['code']?></th>
          <td><?=$mechanic['surname']?></td>
          <td><?=$mechanic['name']?></td>
          <td><?=$mechanic['father_name']?></td>
          <td><?=$mechanic['salary_level']?></td>
          <td><?=$mechanic['salary']?></td>
          <td>
            <a href="?action=edit-mechanic-form&code=<?=$mechanic['code']?>">
                <button type="button" class="btn btn-primary">Змінити</button>
            </a>
            <a href="?action=delete-mechanic&code=<?=$mechanic['code']?>">
                <button type="button" class="btn btn-danger">Видалити</button>
            </a>
          </td>
        </tr>
        <? endforeach; ?>
      </tbody>
    </table>
  </div>
  </body>
</html>