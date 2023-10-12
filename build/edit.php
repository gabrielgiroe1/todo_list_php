<?php
include_once 'pdo.php';
session_start();
if (isset($_POST['list_id'])) {
  $sql = "update todos set title=:title, checked=:checked WHERE list_id=:id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':title' => $_POST['title'], ':checked' => $_POST['checked']));
  $_SESSION['success'] = 'Record updated';
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM todos where list_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['list_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
  $_SESSION['error'] = 'Bad value for list id';
  header('Location: index.php');
  return;
}
$checked = htmlentities($row['checked']);
$title = htmlentities($row['title']);
$list_id = $row['list_id'];
?>
<p>Edit item</p>
<form method="post">
  <p>Name:
    <input type="text" name="title" value="<?= $title ?>">
  </p>
  <p>checked:
    <input type="text" name="checked" value="<?= $checked ?>">
  </p>
  <input type="hidden" name="list_id" value="<?= $list_id ?>">
  <p><input type="submit" value="Update" />
    <a href="index.php">Cancel</a>
  </p>
</form>