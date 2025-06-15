document.addEventListener('DOMContentLoaded', () => {
  const bookingSelect = document.getElementById('bookingIdSelect');
  const deleteBtn = document.getElementById('confirmDeleteBooking');

  // Load all bookings into the <select>
  fetch('http://localhost/seproject/backend/bookings', {
    headers: {
      'Authorization': localStorage.getItem('jwt') || '',
      'Content-Type': 'application/json'
    }
  })
    .then(res => res.json())
    .then(data => {
      bookingSelect.innerHTML = '<option disabled selected value="">Select a booking</option>';
      data.forEach(b => {
        const option = document.createElement('option');
        option.value = b.bookingId;
        option.textContent = `#${b.bookingId} - Accommodation: ${b.accommodationId}, User: ${b.userId}`;
        bookingSelect.appendChild(option);
      });
    })
    .catch(err => {
      console.error('❌ Error loading bookings:', err);
      alert('Failed to load bookings.');
    });

  // Delete booking
  deleteBtn.addEventListener('click', () => {
    const id = bookingSelect.value;
    if (!id) return alert('Please select a booking to delete.');

    if (!confirm("Are you sure you want to delete this booking?")) return;

    fetch(`http://localhost/seproject/backend/bookings/${id}`, {
      method: 'DELETE',
      headers: {
        'Authorization': localStorage.getItem('jwt') || '',
        'Content-Type': 'application/json'
      }
    })
      .then(async res => {
        if (!res.ok) throw new Error(await res.text());
        alert("✅ Booking deleted successfully.");
        location.reload();
      })
      .catch(err => {
        console.error("❌ Failed to delete booking:", err);
        alert("❌ Error: " + err.message);
      });
  });
});

// Show all bookings in modal
$('#allBookingsModal').on('show.bs.modal', function () {
  const token = localStorage.getItem('jwt');
  fetch('http://localhost/seproject/backend/bookings', {
    headers: {
      'Authorization': token || '',
      'Content-Type': 'application/json'
    }
  })
    .then(res => res.json())
    .then(data => {
      const tbody = document.querySelector('#bookingsTable tbody');
      tbody.innerHTML = '';
      data.forEach(b => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${b.bookingId}</td>
          <td>${b.userId}</td>
          <td>${b.accommodationId}</td>
          <td>${b.checkInDate}</td>
          <td>${b.checkOutDate}</td>
          <td>${b.status}</td>
          <td>${b.createdAt}</td>
        `;
        tbody.appendChild(row);
      });
    })
    .catch(err => {
      console.error('❌ Failed to load bookings:', err);
      alert('Error loading bookings.');
    });
});
