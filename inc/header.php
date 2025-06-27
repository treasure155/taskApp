<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TechAlpha Academy - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    body {
      background-color:rgb(255, 255, 255);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      background-color: #2a64c5;
      border: none;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-primary {
      background-color: #fb8127;
      border: none;
      border-radius: 10px;
    }

    .btn-primary:hover {
      background-color: #e86d0d;
    }

    .btn-outline-light {
      border-radius: 10px;
      border: 1px solid #fff;
      color: #fff;
    }

    .btn-outline-light:hover {
      background-color: #ffffff33;
    }

    .gradient-custom-2 {
      background: linear-gradient(to right, #fb8127, #ff9800);
      color: white;
    }

    .text-dark h4, .text-dark p {
      color: white;
    }

    .form-label {
      color: #fff;
    }

    .form-outline input {
      background-color: #ffffffcc;
    }

    .text-muted, .text-muted:hover {
      color: #f1f1f1 !important;
    }

    @media (max-width: 768px) {
      .card {
        margin-top: 2rem;
      }
    }
</style>
</head>
<body>
<header>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">Auth System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>

          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">Register</a>
            </li>
          <?php endif; ?>
          
        </ul>
      </div>
    </div>
  </nav>
</header>
