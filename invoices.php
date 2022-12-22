<?php
require_once 'Db.php';

$db = new Db();
$invoices = $db->getInvoices();

if ($_GET['action'] == 'index') {
    header('Location: index.php');
}

if ($_GET['action'] == 'add-invoice-form') {
    header('Location: invoice_add_edit.php');
}

if ($_GET['action'] == 'edit-invoice-form') {
    $invoice = $db->getInvoice($_GET['code'])[0];
    header('Location: invoice_add_edit.php?code=' . $invoice['code'] .
        "&receiver_code=" . $invoice['receiver_code'] . "&mechanic_code=" . $invoice['mechanic_code'] . "&work_code=" . $invoice['work_code'] .
        "&part_code=" . $invoice['part_code'] . "&price=" . $invoice['price']);
}

if ($_GET['action'] == 'delete-invoice') {
    $db->deleteInvoice($_GET['code']);
    header('Location: invoice.php');
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
    <title>Invoices list</title>
  <style>
    .content {
      width: 600px;
      margin: 15px auto 0;
    }
    h1 {
      margin-bottom: 15px;
    }
    input,
    .table {
        margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="content">
      <a href="?action=index"><button type="button" class="btn btn-primary">Mechanics</button></a>
      <h1>Таблиця Invoices</h1>
      <a href="?action=add-invoice-form"><button type="button" class="btn btn-primary">Додати чек</button></a>
      <table class="table">
          <thead>
          <tr>
              <th scope="col">code</th>
              <th scope="col">date</th>
              <th scope="col">receiver_code</th>
              <th scope="col">mechanic_code</th>
              <th scope="col">work_code</th>
              <th scope="col">part_code</th>
              <th scope="col">price</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <? foreach($invoices as $invoice): ?>
              <tr>
                  <th scope="row"><?=$invoice['code']?></th>
                  <td><?=$invoice['date']->format('Y-m-d H:i:s')?></td>
                  <td><?=$invoice['receiver_code']?></td>
                  <td><?=$invoice['mechanic_code']?></td>
                  <td><?=$invoice['work_code']?></td>
                  <td><?=$invoice['part_code']?></td>
                  <td><?=$invoice['price']?></td>
                  <td>
                      <a href="?action=edit-invoice-form&code=<?=$invoice['code']?>"><button type="button" class="btn btn-primary">Змінити</button></a>
                      <a href="?action=delete-invoice&code=<?=$invoice['code']?>"><button type="button" class="btn btn-danger">Видалити</button></a>
                  </td>
              </tr>
          <? endforeach; ?>
          </tbody>
      </table>
  </div>
  </body>
</html>