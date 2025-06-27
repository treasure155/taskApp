<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('inc/header.php');
require 'config/config.php';
require 'vendor/autoload.php';

$user_id = $_SESSION['user_id'];
$success = "";

// Delete task
if (isset($_GET['delete_task'])) {
    $task_id = $_GET['delete_task'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND created_by = ?");
    if ($stmt->execute([$task_id, $user_id])) {
        $success = "Task deleted successfully.";
    }
}

// Mark as done (only if assigned user has completed it)
if (isset($_GET['mark_done'])) {
    $task_id = $_GET['mark_done'];
    $stmt = $pdo->prepare("UPDATE tasks SET creator_status = 'done' WHERE id = ? AND created_by = ? AND status = 'completed'");
    if ($stmt->execute([$task_id, $user_id])) {
        $success = "Task marked as done.";
    }
}

// Resend notification (can just reset the `creator_status`)
if (isset($_GET['resend'])) {
    $task_id = $_GET['resend'];
    $stmt = $pdo->prepare("UPDATE tasks SET creator_status = 'notified' WHERE id = ? AND created_by = ?");
    if ($stmt->execute([$task_id, $user_id])) {
        $success = "Notification resent.";
    }
}

// Fetch created tasks
$stmt = $pdo->prepare("SELECT t.*, u.name AS assignee_name FROM tasks t JOIN users u ON t.assigned_to = u.id WHERE t.created_by = ? ORDER BY t.created_at DESC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h4 class="mb-4">Tasks You Created</h4>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (count($tasks) === 0): ?>
        <p>You haven't created any tasks yet.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($tasks as $task): ?>
                <div class="list-group-item">
                    <h5><?php echo htmlspecialchars($task['title']); ?></h5>
                    <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                    <small>Assigned to: <?php echo htmlspecialchars($task['assignee_name']); ?> | Status: 
                        <span class="badge bg-<?php echo $task['status'] === 'completed' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst($task['status']); ?>
                        </span>
                        | Creator Status: 
                        <span class="badge bg-<?php echo $task['creator_status'] === 'done' ? 'secondary' : 'info'; ?>">
                            <?php echo ucfirst($task['creator_status']); ?>
                        </span>
                    </small>
                    <div class="mt-2">
                        <a href="edit_task.php?task_id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                        <a href="?delete_task=<?php echo $task['id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-sm btn-danger">Delete</a>
                        <?php if ($task['status'] === 'completed' && $task['creator_status'] !== 'done'): ?>
                            <a href="?mark_done=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">Mark as Done</a>
                        <?php endif; ?>
                        <a href="?resend=<?php echo $task['id']; ?>" class="btn btn-sm btn-warning">Resend Notification</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include('inc/footer.php'); ?>
