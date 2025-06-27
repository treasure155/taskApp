<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include('inc/header.php');
require 'config/config.php';
require 'vendor/autoload.php';

$user_id = $_SESSION['user_id'];
$task_id = $_GET['task_id'] ?? null;

if (!$task_id) {
    echo "<p class='text-danger'>No task selected.</p>";
    exit;
}

// Fetch the task to edit (and check ownership)
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND created_by = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch();

if (!$task) {
    echo "<p class='text-danger'>Task not found or you are not authorized to edit this task.</p>";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if ($title && $description) {
        $update = $pdo->prepare("UPDATE tasks SET title = ?, description = ? WHERE id = ? AND created_by = ?");
        $update->execute([$title, $description, $task_id, $user_id]);
        header("Location: my_tasks.php?updated=1");
        exit;
    } else {
        $error = "Please fill in both title and description.";
    }
}
?>

<div class="container mt-5">
    <h4>Edit Task</h4>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4" style="max-width: 600px;">
        <div class="mb-3">
            <label for="title" class="form-label">Task Title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Task Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Update Task</button>
        <a href="my_tasks.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include('inc/footer.php'); ?>
