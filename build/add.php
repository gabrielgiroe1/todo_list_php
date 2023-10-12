<?php
if (isset($_POST['title'])) {
  include_once 'pdo.php';
  $title = $_POST['title'];
  if (empty($title)) {
    $_SESSION['error'] = 'Error';
    header("Location: index.php");
    return;
  }else{
    $stmt = $pdo->prepare("insert into todos(user_id, title) values(1, ?)");
    $res = $stmt->execute([$title]);
    if ($res){
      $_SESSION['success'] = 'Record added';
      header("Location: index.php");
      return;
    }else{
      $_SESSION['success'] = 'Record added';
      header("Location: index.php");
      return;
    }
    $pdo = null;
    exit();
  }
}else{
  $_SESSION['error'] = 'Error';
  header("Location: index.php");
  return;
}
?>