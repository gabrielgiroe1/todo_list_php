<?php
session_start();
include_once 'pdo.php';
if (isset($_POST['list_id'])) {
  // $id = $_GET["list_id"];
  $sql = "delete from todos where list_id =:zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['list_id']));
  $_SESSION['success'] = "Item deleted";
  header('location: index.php');
  return;
}
$stmt = $pdo->prepare("SELECT title, list_id from todos where list_id =:xyz");
$stmt->execute(array(':xyz' => $_GET['list_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
  $_SESSION['error'] = "bad id number";
  header("location: index.php");
  return;
}
?>
<p>Confirm deleting
  <?= htmlentities($row['title']) ?>
</p>
<form method="post">
  <input type="hidden" name="list_id" value="<?= $row['list_id'] ?>">
  <input type="submit" value="Delete" name="delete" />
  <a href="index.php">Cancel</a>
</form>