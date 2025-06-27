<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include('inc/header.php');
require 'config/config.php';
require 'vendor/autoload.php';


$user_id = $_SESSION['user_id'];
$success = "";

// Handle task completion
if (isset($_GET['complete_task'])) {
    $task_id = $_GET['complete_task'];

    $stmt = $pdo->prepare("UPDATE tasks SET status = 'completed' WHERE id = ? AND assigned_to = ?");
    if ($stmt->execute([$task_id, $user_id])) {
        $success = "Task marked as completed!";
    }
}

// Fetch tasks assigned to current user
$stmt = $pdo->prepare("SELECT t.*, u.name as creator_name 
                       FROM tasks t 
                       JOIN users u ON t.created_by = u.id 
                       WHERE t.assigned_to = ? 
                       ORDER BY t.created_at DESC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h4 class="mb-4">Tasks Assigned to You</h4>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (count($tasks) === 0): ?>
        <p>No tasks assigned yet.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($tasks as $task): ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1"><?php echo htmlspecialchars($task['title']); ?></h5>
                        <small>From: <?php echo htmlspecialchars($task['creator_name']); ?> | Created: <?php echo $task['created_at']; ?></small>
                        <p class="mb-0 mt-1"><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                        <span class="badge bg-<?php echo $task['status'] === 'completed' ? 'success' : 'warning'; ?>">
                            <?php echo ucfirst($task['status']); ?>
                        </span>
                    </div>
                    <?php if ($task['status'] !== 'completed'): ?>
                        <a href="?complete_task=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">Mark as Completed</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include('inc/footer.php'); ?>
