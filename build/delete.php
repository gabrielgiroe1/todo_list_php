<?php
session_start();
include_once 'pdo.php';
if (isset($_POST['list_id'])) {
  $sql = "delete from todos where list_id =:zip";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(':zip' => $_POST['list_id']));
  $_SESSION['success'] = "Item deleted";
  header('location: index.php');
  return;
}
$stmt = $pdo->prepare("SELECT title, checked, list_id from todos where list_id =:xyz");
$stmt->execute(array(':xyz' => $_GET['list_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row == false) {
  $_SESSION['error'] = "Bad id number";
  header("location: index.php");
  return;
}
$title = $row['title'];
$checked = $row['checked'];
$list_id = $row['list_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>Delete Item</title>
</head>

<body class="min-h-screen bg-slate-50 dark:bg-black dark:text-white">
  <section class="pt-6 mt-12">
    <h2 class="text-4xl font-bold text-center sm:text-5xl mb-6 text-slate-900 dark:text-white">
      Delete your item from your list.
    </h2>
    <ul class="list-none mx-auto mt-12 flex flex-col sm:flex-row items-center gap-8">
      <li
        class="w-2/3 sm:w-5/6 flex flex-col items-center border border-solid border-slate-900 dark:border-gray-100 bg-white py-6 px-2 rounded-3xl shadow-xl">
        <h3 class="text-3xl text-center text-slate-900 dark-text-white">
          <div class="main-section">
            <div class="edit-section">
              <form method="post">
                <div class="p-4 max-w-md mx-auto bg-white rounded-lg shadow-md">
                  <p class="text-lg font-semibold">Delete item</p>
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
                    <button type="submit" class=" text-red px-4 py-2 rounded-lg hover:bg-red-700">Delete</button>

                    <a href="index.php" class="text-blue-500 hover:text-blue-700">Cancel</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </h3>
      </li>
    </ul>
  </section>
</body>

</html>