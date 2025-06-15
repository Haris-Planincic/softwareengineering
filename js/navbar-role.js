document.addEventListener("DOMContentLoaded", () => {
  const loginBtn = document.getElementById("btn-login");
  const registerBtn = document.getElementById("btn-register");
  const logoutBtn = document.getElementById("btn-logout");
  const adminNavItem = document.getElementById("admin-nav-item");

  const token = localStorage.getItem("jwt_token");
  const role = localStorage.getItem("user_role");

  // Show/hide elements based on auth status
  if (token) {
    if (loginBtn) loginBtn.style.display = "none";
    if (registerBtn) registerBtn.style.display = "none";
    if (logoutBtn) logoutBtn.style.display = "inline-block";

    if (role === "admin" && adminNavItem) {
      adminNavItem.style.display = "inline-block";
    } else if (adminNavItem) {
      adminNavItem.style.display = "none";
    }
  } else {
    if (loginBtn) loginBtn.style.display = "inline-block";
    if (registerBtn) registerBtn.style.display = "inline-block";
    if (logoutBtn) logoutBtn.style.display = "none";
    if (adminNavItem) adminNavItem.style.display = "none";
  }

  // Logout button functionality
  if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
      localStorage.removeItem("jwt_token");
      localStorage.removeItem("user_role");
      alert("Logged out successfully.");
      window.location.href = "index.html";
    });
  }
});
