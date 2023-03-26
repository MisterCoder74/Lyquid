<?php
// Read the tasks from the JSON file
$tasks = json_decode(file_get_contents('../dbs/admin_tasks.json'), true);

// Get the current date and time
$current_datetime = new DateTime();

// Loop through the tasks and remove those that are past due
foreach ($tasks as $key => $task) {
  $task_datetime = new DateTime($task['date'] . ' ' . $task['time']);
  if ($task_datetime < $current_datetime) {
    unset($tasks[$key]);
  }
}

// Save the updated tasks to the JSON file
file_put_contents('../dbs/admin_tasks.json', json_encode(array_values($tasks)));
?>
