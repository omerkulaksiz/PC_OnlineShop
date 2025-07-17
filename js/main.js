document.addEventListener("DOMContentLoaded", function () {
  const params = new URLSearchParams(window.location.search);
  const tab = params.get("tab");
  const error = params.get("error");
  const success = params.get("success");

  // Switch tab if needed
  if (tab === "login") {
    document.getElementById("login-tab").classList.add("active");
    document.getElementById("register-tab").classList.remove("active");
    document.getElementById("login").classList.add("show", "active");
    document.getElementById("register").classList.remove("show", "active");
  } else {
    document.getElementById("register-tab").classList.add("active");
    document.getElementById("login-tab").classList.remove("active");
    document.getElementById("register").classList.add("show", "active");
    document.getElementById("login").classList.remove("show", "active");
  }

  // Show error message
  if (error) {
    const alert = document.createElement("div");
    alert.className = "alert alert-danger mt-3";
    alert.role = "alert";
    alert.innerText = decodeURIComponent(error);
    if (tab === "login") {
      document.getElementById("loginForm").before(alert);
    } else {
      document.getElementById("registerForm").before(alert);
    }
  }

  // Show success message
  if (success) {
    const alert = document.createElement("div");
    alert.className = "alert alert-success mt-3";
    alert.role = "alert";
    alert.innerText = decodeURIComponent(success);
    document.getElementById("loginForm").before(alert);
  }
});
