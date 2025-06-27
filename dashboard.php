<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include('inc/header.php');
require 'config/config.php';  // This includes the PDO connection

$user_id = $_SESSION['user_id'];

// Count unread notifications (tasks not marked as seen)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND seen = 0");
$stmt->execute([$user_id]);
$unread_notifications = $stmt->fetchColumn();

// Count pending tasks (tasks that are assigned but not completed)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND status != 'completed'");
$stmt->execute([$user_id]);
$pending_tasks = $stmt->fetchColumn();
?>

<style>
    body {
        background-color: #f8f9fa;
    }
    .sidebar {
        height: 100vh;
        background-color: #1b479e;
        color: white;
        padding: 1rem;
    }
    .sidebar a {
        color: white;
        text-decoration: none;
        display: block;
        padding: 10px 0;
    }
    .sidebar a:hover {
        background-color: #fb8127;
        border-radius: 5px;
        padding-left: 10px;
    }
    .badge {
        font-size: 12px;
        background-color: #ffc107;
        color: white;
        border-radius: 50%;
        padding: 3px 7px;
        position: absolute;
        top: -5px;
        right: -10px;
    }
    .badge.bg-danger {
        background-color: #dc3545;
    }
    .main-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
    }
    .main-content h2 {
        font-size: 2rem;
    }
    .task-info {
        font-size: 1.2rem;
        margin-top: 10px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar">
            <h4>Menu</h4>
            <a href="dashboard.php">🏠 Dashboard</a>
            <a href="create_task.php">📝 Create Task</a>
            <a href="assigned_tasks.php">📥 Assigned Tasks
                <?php if ($pending_tasks > 0): ?>
                    <span class="badge bg-danger"><?php echo $pending_tasks; ?></span>
                <?php endif; ?>
            </a>
            <a href="my_tasks.php">📤 My Created Tasks</a>
            <a href="notifications.php">🔔 Notifications
                <?php if ($unread_notifications > 0): ?>
                    <span class="badge"><?php echo $unread_notifications; ?></span>
                <?php endif; ?>
            </a>
            <a href="logout.php">🚪 Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-5">
            <div class="main-content">
                <div class="card shadow-lg p-4" style="border-radius: 15px;">
                    <div class="card-body text-center">
                        <h2 class="card-title mb-3">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
                        <p class="card-text">You are now logged in to your dashboard.</p>
                    </div>
                </div>

                <!-- Task Info -->
                <div class="task-info">
                    <h4>Task Overview</h4>
                    <p>You have <strong><?php echo $pending_tasks; ?></strong> pending task(s).</p>
                    <p>You have <strong><?php echo $unread_notifications; ?></strong> unread notification(s).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>
