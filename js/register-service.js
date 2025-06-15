document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("register-form");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();

    const firstName = document.getElementById("first_name").value.trim();
    const lastName = document.getElementById("last_name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("pwd").value.trim();

    if (!firstName || !lastName || !email || !password) {
      alert("⚠️ Please fill out all fields.");
      return;
    }

    const user = {
      firstName,
      lastName,
      email,
      password
    };

    try {
      const res = await fetch("http://localhost/seproject/backend/auth/register", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(user)
      });

      if (!res.ok) throw new Error(`Failed: ${res.status}`);
      const result = await res.json();
      alert("Registration successful!");
      window.location.href = "login.html";
    } catch (err) {
      console.error("Registration error:", err);
      alert("Failed to register. Please try again.");
    }
  });
});