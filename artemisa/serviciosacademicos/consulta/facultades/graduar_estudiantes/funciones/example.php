<!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
<title>Progress Bar Example</title>
</head>
<body>
<?php
include("class.progress_bar.php");

$pbar = new progress_bar('pbar',1,500,FALSE); //Creates a 500 pixle width progress bar starting at 1 percent with the name pbar auto create = false

$num_tasks = 500; // the number of tasks to be completed.
$pbar->create(); // Visually creates the progress bar.

for($cur_task = 0; $cur_task <= $num_tasks; $cur_task++)
{
	echo("<p>Task $cur_task complete.</p>"); // Execute the current task.
	usleep(10000); // delays exicution 10000 microseconds to show effect of progression.
	flush();
	$pbar->set_percent_adv($cur_task,$num_tasks); // tells the progress bar that $cur_task of the 500 tasks is completed.
}
?>
</body>
</html>