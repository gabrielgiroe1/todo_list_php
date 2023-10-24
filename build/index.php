<?php
include_once 'pdo.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>todo_list</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="min-h-screen bg-slate-50 dark:bg-black dark:text-white">
  <header class="bg-teal-700 text-white sticky top-0 z-10">
    <section class="max-w-4xl mx-auto p-4 flex justify-between items-center">
      <h1 class="text-3xl font-medium">
        <a href="#list" class="cursor-pointer">🚀 Todo List</a>
      </h1>
      <div class="max-w-3xl align-right">
        👤
      </div>
    </section>
  </header>

  <?php
  if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
    echo '<p style="color:green">' . $_SESSION['success'] . "</p>\n";
    unset($_SESSION['success']);
  }
  ?>

  <main class="max-w-4xl mx-auto">
    <main class="max-w-4xl mx-auto">
      <section class="pt-6 mt-12">
        <h2 class="text-4xl font-bold text-center sm:text-5xl mb-6 text-slate-900 dark:text-white">
          Add your todo list here..
        </h2>
        <ul class="list-none mx-auto mt-12 flex flex-col sm:flex-row items-center gap-8">
          <li
            class="w-2/3 sm:w-5/6 flex flex-col items-center border border-solid border-slate-900 dark:border-gray-100 bg-white py-6 px-2 rounded-3xl shadow-xl">
            ✍️📓
            <h3 class="text-3xl text-center text-slate-900 dark-text-white">
              <div class="main-section">
                <div class="add-section">
                  <form action="add.php" method="post" autocomplete="off">
                    <?php if (isset($_GET['message']) && $_GET['message'] == 'error') { ?>
                      <input type="text" id="addTodo" name="title" class="border border-red-600"
                        placeholder="This field is required...">
                      <br>
                      <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-800 text-white rounded-md transition-colors duration-300 ease-in-out">Add</button>
                    <?php } else { ?>
                      <input type="text" id="addTodo" name="title" class="border-solid" placeholder="Add new todo..">
                      <br>
                      <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-800 text-white rounded-md transition-colors duration-300 ease-in-out">Add</button>
                    <?php } ?>
                  </form>
                </div>
              </div>
            </h3>
          </li>
        </ul>
      </section>



      <section class="pb-6 mb-12">
        <ul class="list-none mx-auto mb-12 flex flex-col sm:flex-row items-center gap-8">
          <li
            class="w-2/3 sm:w-5/6 flex flex-col items-center border border-solid border-slate-900 dark:border-gray-100 bg-white py-6 px-2 rounded-3xl shadow-xl">
            <h3 class="text-3xl text-center text-slate-900 dark-text-white">
              <div class="main-section">
                <?php
                $todos = $pdo->query("select * from todos order by list_id desc");
                ?>

                <div class="show-todo-section">
                  <?php
                  if ($todos->rowCount() <= 0) {
                    ?>
                    <div class="todo-item">
                      <div class="empty">
                        <img src="img/empty.png" alt="" class="w-1/2">
                      </div>
                    </div>
                  </div>
                <?php } ?>

                <?php
                while ($result = $todos->fetch(PDO::FETCH_ASSOC)) { ?>
                  <div class="todo-item mb-2">
                    <h2 class="checked">
                      <?php echo $result['title']; ?>
                    </h2>
                    <?php if ($result['checked']) { ?>
                      <input type="checkbox" class="check-box text-left" checked />
                      <?php echo '<a class="text-blue-500 hover:text-blue-800 mr-2 text-center" href="edit.php?list_id=' . $result['list_id'] . '">Edit</a>'; ?>
                      <?php echo '<a class="remove-todo" name="remove-todo" href="delete.php?list_id=' . $result['list_id'] . '">x</a>' ?>
                    <?php } else { ?>
                      <input type="checkbox" class="check-box text-left" />
                      <?php echo '<a class="text-blue-500 hover:text-blue-800 mr-2 text-center" href="edit.php?list_id=' . $result['list_id'] . '">Edit</a>'; ?>
                      <?php echo '<a class="remove-todo" name="remove-todo" href="delete.php?list_id=' . $result['list_id'] . '">x</a>' ?>
                    <?php } ?>
                    <br>
                    <small>created:
                      <?php echo $result['date_time']; ?>
                    </small>
                    <hr>
                  </div>

                <?php } ?>
              </div>
            </h3>
          </li>

        </ul>
      </section>


    </main>
</body>

</html>