<?php
include_once 'pdo.php';
session_start();
if (isset($_POST['list_id'])) {
  $sql = "update todos set title=:title, checked=:checked WHERE list_id=:id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(
    array(
      ':title' => $_POST['title'],
      ':checked' => $_POST['checked'],
      ':id' => $_POST['list_id'],
    )
  );
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="min-h-screen bg-slate-50 dark:bg-black dark:text-white">
  <section class="pt-6 mt-12">
    <h2 class="text-4xl font-bold text-center sm:text-5xl mb-6 text-slate-900 dark:text-white">
      Edit your item form your list..
    </h2>
    <ul class="list-none mx-auto mt-12 flex flex-col sm:flex-row items-center gap-8">
      <li
        class="w-2/3 sm:w-5/6 flex flex-col items-center border border-solid border-slate-900 dark:border-gray-100 bg-white py-6 px-2 rounded-3xl shadow-xl">
        <h3 class="text-3xl text-center text-slate-900 dark-text-white">
          <div class="main-section">
            <div class="edit-section">
                  <form method="post">
                  <div class="p-4 max-w-md mx-auto bg-white rounded-lg shadow-md">
                  <p class="text-lg font-semibold">Edit item</p>
                    <div class="mb-4">
                      <label for="title" class="block text-sm font-medium text-gray-700">Name:</label>
                      <input type="text" name="title" id="title" value="<?= $title ?>"
                        class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:border-blue-500" />
                    </div>

                    <div class="mb-4">
                      <label for="checked" class="block text-sm font-medium text-gray-700">Checked:</label>
                      <input type="text" name="checked" id="checked" value="<?= $checked ?>"
                        class="w-full px-3 py-2 border rounded-lg shadow-sm focus:outline-none focus:border-blue-500" />
                    </div>

                    <input type="hidden" name="list_id" value="<?= $list_id ?>" />

                    <div class="flex items-center space-x-4">
                      <button type="submit"
                        class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-200">Update</button>
                      <a href="index.php" class="text-blue-500 hover:text-blue-700">Cancel</a>
                    </div>
                  </form>
                </div>
            </div>
          </div>
        </h3>
      </li>
    </ul>
  </section>
</body>

</html>