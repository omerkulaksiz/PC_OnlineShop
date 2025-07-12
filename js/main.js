  // Registrierung
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    document.getElementById('registerSuccess').classList.remove('d-none');
    // Optional: Wechsel zum Login-Tab nach Registrierung
    setTimeout(function() {
      var loginTab = document.getElementById('login-tab');
      var tab = new bootstrap.Tab(loginTab);
      tab.show();
    }, 3000);
  });

  // Login
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    var email = document.getElementById('loginEmail').value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var errorDiv = document.getElementById('loginError');
    if (emailPattern.test(email)) {
      errorDiv.classList.add('d-none');
      // Redirect to another page (URL left empty as requested)
      window.location.href = '';
    } else {
      errorDiv.classList.remove('d-none');
    }
  });
