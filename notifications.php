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
$success = "";

// Mark task as seen
if (isset($_GET['mark_seen'])) {
    $task_id = $_GET['mark_seen'];
    $stmt = $pdo->prepare("UPDATE tasks SET seen = 1 WHERE id = ? AND assigned_to = ?");
    $stmt->execute([$task_id, $user_id]);
}

// Mark task as completed by assignee
if (isset($_GET['complete_task'])) {
    $task_id = $_GET['complete_task'];
    $stmt = $pdo->prepare("UPDATE tasks SET status = 'completed' WHERE id = ? AND assigned_to = ?");
    $stmt->execute([$task_id, $user_id]);
    $success = "Task marked as completed.";
}

// Fetch assigned tasks
$stmt = $pdo->prepare("SELECT t.*, u.name AS creator_name FROM tasks t JOIN users u ON t.created_by = u.id WHERE t.assigned_to = ? ORDER BY t.created_at DESC");
$stmt->execute([$user_id]);
$notifications = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h4>Notifications & Assigned Tasks</h4>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if (count($notifications) === 0): ?>
        <p>No tasks have been assigned to you yet.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($notifications as $task): ?>
                <div class="list-group-item">
                    <h5>
                        <?php echo htmlspecialchars($task['title']); ?>
                        <?php if (!$task['seen']): ?>
                            <span class="badge bg-warning">New</span>
                        <?php endif; ?>
                    </h5>
                    <p><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                    <small>Assigned by: <strong><?php echo htmlspecialchars($task['creator_name']); ?></strong> | Status: 
                        <span class="badge bg-<?php echo $task['status'] === 'completed' ? 'success' : 'secondary'; ?>">
                            <?php echo ucfirst($task['status']); ?>
                        </span>
                    </small>
                    <div class="mt-2">
                        <?php if (!$task['seen']): ?>
                            <a href="?mark_seen=<?php echo $task['id']; ?>" class="btn btn-sm btn-info">Mark as Seen</a>
                        <?php endif; ?>
                        <?php if ($task['status'] !== 'completed'): ?>
                            <a href="?complete_task=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">Mark as Completed</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include('inc/footer.php'); ?>
