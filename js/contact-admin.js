document.addEventListener('DOMContentLoaded', () => {
  const select = document.getElementById('contactIdSelect');
  const deleteButton = document.getElementById('confirmDeleteContact');

  // Load contact messages into the dropdown
  fetch('http://localhost/seproject/backend/contacts', {
    headers: {
      'Authorization': localStorage.getItem('jwt') || '',
      'Content-Type': 'application/json'
    }
  })
    .then(async response => {
      if (!response.ok) {
        const errorText = await response.text();
        throw new Error("Failed to fetch messages: " + errorText);
      }
      return response.json();
    })
    .then(data => {
      select.innerHTML = '<option disabled selected value="">Select a message</option>';
      data.forEach(msg => {
        const option = document.createElement('option');
        option.value = msg.messageId;
        option.textContent = `#${msg.messageId} - ${msg.firstName} ${msg.lastName}`;
        select.appendChild(option);
      });
    })
    .catch(error => {
      console.error('❌ Error loading messages:', error.message);
      alert('❌ Could not load contact messages: ' + error.message);
    });

  // Delete contact message by ID
  deleteButton.addEventListener('click', () => {
    const selectedId = select.value;
    if (!selectedId) {
      alert("Please select a contact message to delete.");
      return;
    }

    if (!confirm("Are you sure you want to delete this message?")) return;

    console.log("Attempting to delete message ID:", selectedId);

    fetch(`http://localhost/seproject/backend/contacts/${selectedId}`, {
      method: 'DELETE',
      headers: {
        'Authorization': localStorage.getItem('jwt') || '',
        'Content-Type': 'application/json'
      }
    })
      .then(async response => {
        if (!response.ok) {
          const errorText = await response.text();
          throw new Error(errorText || `HTTP ${response.status}`);
        }
        alert("✅ Message deleted successfully.");
        location.reload();
      })
      .catch(error => {
        console.error("❌ Error deleting message:", error.message);
        alert("❌ Backend error: " + error.message);
      });
  });
});
