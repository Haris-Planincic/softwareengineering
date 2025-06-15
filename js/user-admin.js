document.addEventListener('DOMContentLoaded', () => {
  const select = document.getElementById('userIdSelect');
  const deleteBtn = document.getElementById('deleteUserBtn');
  const addBtn = document.getElementById('addUserBtn');

  // Load users into dropdown
  fetch('http://localhost/seproject/backend/users', {
  headers: {
    'Authorization': `Bearer ${localStorage.getItem('jwt_token') || ''}`,
    'Content-Type': 'application/json'
  }
})

    .then(res => {
      if (!res.ok) throw new Error("Failed to load users");
      return res.json();
    })
    .then(users => {
      if (select) {
        select.innerHTML = '<option disabled selected value="">Select a user</option>';
        users.forEach(user => {
          const option = document.createElement('option');
          option.value = user.userId;
          option.textContent = `#${user.userId} - ${user.email}`;
          select.appendChild(option);
        });
      }
    })
    .catch(err => {
      console.error('❌ Error loading users:', err);
      alert('Failed to load user list.');
    });

  // Delete user
  if (deleteBtn) {
    deleteBtn.addEventListener('click', () => {
      const id = select.value;
      if (!id) {
        alert('Please select a user.');
        return;
      }

      if (!confirm('Are you sure you want to delete this user?')) return;

      fetch(`http://localhost/seproject/backend/users/${id}`, {
  method: 'DELETE',
  headers: {
    'Authorization': `Bearer ${localStorage.getItem('jwt_token') || ''}`,
    'Content-Type': 'application/json'
  }
})

        .then(async res => {
          if (!res.ok) throw new Error(await res.text());
          alert('✅ User deleted successfully.');
          location.reload();
        })
        .catch(err => {
          console.error('❌ Failed to delete user:', err);
          alert('❌ Error: ' + err.message);
        });
    });
  }

  // Add new user
  if (addBtn) {
    addBtn.addEventListener('click', () => {
      const data = {
        firstName: document.getElementById('newFirstName').value,
        lastName: document.getElementById('newLastName').value,
        email: document.getElementById('newEmail').value,
        password: document.getElementById('newPassword').value,
        role: document.getElementById('newRole').value
      };

      if (!data.firstName || !data.lastName || !data.email || !data.password || !data.role) {
        alert("❌ Please fill in all fields.");
        return;
      }

      fetch('http://localhost/seproject/backend/users', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${localStorage.getItem('jwt_token') || ''}`,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify(data)
})

        .then(async res => {
          if (!res.ok) throw new Error(await res.text());
          alert('✅ User added successfully!');
          location.reload();
        })
        .catch(err => {
          console.error('❌ Failed to add user:', err);
          alert('❌ Error: ' + err.message);
        });
    });
  }
});
