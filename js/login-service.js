document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("login-form");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("pwd").value.trim();

    if (!email || !password) {
      alert("⚠️ Please fill in both email and password.");
      return;
    }

    try {
      const res = await fetch("http://localhost/seproject/backend/auth/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password })
      });

      if (!res.ok) throw new Error(`Failed: ${res.status}`);

      const result = await res.json();
      const token = result.data.token;
      const role = result.data.role;

     
      localStorage.setItem("jwt_token", token);
      localStorage.setItem("user_role", role);

      alert("Login successful!");
      window.location.href = "index.html"; 

    } catch (err) {
      console.error("Login error:", err);
      alert("Login failed. Please check your credentials.");
    }
  });
});