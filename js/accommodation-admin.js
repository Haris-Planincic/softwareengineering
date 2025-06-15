document.addEventListener('DOMContentLoaded', () => {
  const select = document.getElementById('accommodationIdSelect');
  const deleteBtn = document.getElementById('confirmDeleteAccommodation');
  const addBtn = document.getElementById('submitAccommodation');

  // Load accommodations into dropdown
  fetch('http://localhost/seproject/backend/accommodations', {
    headers: {
      'Authorization': localStorage.getItem('jwt') || '',
      'Content-Type': 'application/json'
    }
  })
    .then(res => res.json())
    .then(data => {
      if (select) {
        select.innerHTML = '<option disabled selected value="">Select an accommodation</option>';
        data.forEach(acc => {
          const option = document.createElement('option');
          option.value = acc.accommodationId;
          option.textContent = `#${acc.accommodationId} - ${acc.name}`;
          select.appendChild(option);
        });
      }
    })
    .catch(err => {
      console.error('❌ Error loading accommodations:', err);
      alert('Failed to load accommodation list.');
    });

  // Delete accommodation
  if (deleteBtn) {
    deleteBtn.addEventListener('click', () => {
      const id = select.value;
      if (!id) {
        alert('Please select an accommodation.');
        return;
      }

      if (!confirm('Are you sure you want to delete this accommodation?')) return;

      fetch(`http://localhost/seproject/backend/accommodations/${id}`, {
        method: 'DELETE',
        headers: {
          'Authorization': localStorage.getItem('jwt') || '',
          'Content-Type': 'application/json'
        }
      })
        .then(async res => {
          if (!res.ok) throw new Error(await res.text());
          alert('✅ Accommodation deleted successfully.');
          location.reload();
        })
        .catch(err => {
          console.error('❌ Failed to delete accommodation:', err);
          alert('❌ Error: ' + err.message);
        });
    });
  }

  // Add new accommodation
  if (addBtn) {
    addBtn.addEventListener('click', () => {
      const data = {
        name: document.getElementById('accName').value,
        location: document.getElementById('accLocation').value,
        pricePerNight: parseFloat(document.getElementById('accPrice').value),
        category: document.getElementById('accCategory').value,
        description: document.getElementById('accDescription').value,
        imageUrls: document.getElementById('accImageUrl').value
      };

      // Basic validation
      if (
        !data.name || !data.location || !data.pricePerNight || !data.category ||
        !data.description || !data.imageUrls
      ) {
        alert("❌ Please fill in all fields.");
        return;
      }

      fetch('http://localhost/seproject/backend/accommodations', {
        method: 'POST',
        headers: {
          'Authorization': localStorage.getItem('jwt') || '',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      })
        .then(async res => {
          if (!res.ok) throw new Error(await res.text());
          alert('✅ Accommodation added successfully!');
          location.reload();
        })
        .catch(err => {
          console.error('❌ Failed to add accommodation:', err);
          alert('❌ Error: ' + err.message);
        });
    });
  }
});
