<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Include header, config (which contains PDO), and vendor autoload
include('inc/header.php');
require 'config/config.php';  // Ensure this is after the session_start()

$errors = [];
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $assigned_to = $_POST['assigned_to'];
    $created_by = $_SESSION['user_id'];
    $due_date = $_POST['due_date'];  // Capture the due date

    // Basic validation
    if (empty($title) || empty($description) || empty($assigned_to) || empty($due_date)) {
        $errors[] = "All fields are required.";
    } else {
        // Insert task into the database using PDO
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description, created_by, assigned_to, due_date) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $created_by, $assigned_to, $due_date])) {
            $success = "Task created and assigned successfully!";
        } else {
            $errors[] = "Failed to assign task. Please try again.";
        }
    }
}

// Fetch all users except the current one
$stmt = $pdo->prepare("SELECT id, name FROM users WHERE id != ?");
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg p-4">
                <h4 class="mb-3">Create New Task</h4>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) echo "<p>$error</p>"; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Task Description</label>
                        <textarea class="form-control" name="description" id="description" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assign To</label>
                        <select name="assigned_to" class="form-select" required>
                            <option value="">-- Select User --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date & Time</label>
                        <input type="datetime-local" class="form-control" name="due_date" id="due_date" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Task</button>
                    <a href="dashboard.php" class="btn btn-secondary ms-2">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php'); ?>
