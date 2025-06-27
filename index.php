<?php include('inc/header.php'); ?>

<section class="h-100 bg-dark">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card text-white">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

              <div class="text-center mb-4">
                  <img src="assests/images/TechAlpha2.png" style="width: 200px;" alt="TechAlpha Logo"/>
                  <h4 class="mt-3 mb-4">TechAlpha Tasks App</h4>
                </div>

                <!-- Toggle Buttons -->
                <div class="mb-4 text-center">
                  <button class="btn btn-primary me-2" id="showLoginBtn">Login</button>
                  <button class="btn btn-outline-light text-dark" id="showRegisterBtn">Register</button>
                </div>

                <!-- Login Form -->
                <form action="process.php" method="POST" id="loginForm">
                  <p class="text-white">Login to manage your tasks and stay organized!</p>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="email">Email or Username</label>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Enter email or username" required />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required />
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary w-100 mb-3" type="submit" name="login">
                      <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                    <a class="text-muted" href="#">Forgot password?</a>
                  </div>
                </form>

                <!-- Registration Form (Initially Hidden) -->
                <form action="process.php" method="POST" id="registerForm" style="display: none;">
                  <p class="text-white">Join TechAlpha and start managing your tasks effectively!</p>

                  <div class="form-outline mb-3">
                    <label class="form-label" for="name">Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required />
                  </div>

                  <div class="form-outline mb-3">
                    <label class="form-label" for="reg-email">Email</label>
                    <input type="email" id="reg-email" name="email" class="form-control" placeholder="Enter email" required />
                  </div>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="reg-password">Password</label>
                    <input type="password" id="reg-password" name="password" class="form-control" placeholder="Create password" required />
                  </div>

                  <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" name="register" class="btn btn-primary w-100">
                      <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                  </div>
                </form>

              </div>
            </div>

            <div class="col-lg-6 d-flex align-items-center gradient-custom-2 rounded-end">
              <div class="text-white px-4 py-5 text-center">
                <h4 class="mb-4">Welcome to TechAlpha Task Management</h4>
                <p class="small">Stay on top of your tasks, manage assignments, and collaborate with your team. Manage your tasks effectively and get things done with TechAlpha Task App.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- JS to Toggle Forms -->
<script>
  const showLoginBtn = document.getElementById('showLoginBtn');
  const showRegisterBtn = document.getElementById('showRegisterBtn');
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');

  showLoginBtn.addEventListener('click', () => {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';

    showLoginBtn.classList.add('btn-primary');
    showLoginBtn.classList.remove('btn-outline-light', 'text-dark');

    showRegisterBtn.classList.remove('btn-primary');
    showRegisterBtn.classList.add('btn-outline-light', 'text-dark');
  });

  showRegisterBtn.addEventListener('click', () => {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';

    showRegisterBtn.classList.add('btn-primary');
    showRegisterBtn.classList.remove('btn-outline-light', 'text-dark');

    showLoginBtn.classList.remove('btn-primary');
    showLoginBtn.classList.add('btn-outline-light', 'text-dark');
  });
</script>

<?php include('inc/footer.php'); ?>
