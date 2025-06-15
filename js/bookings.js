document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const accommodationId = urlParams.get('accommodationId');

  if (!accommodationId) {
    alert("Missing accommodation ID");
    window.location.href = "services.html";
    return;
  }

  let checkInDate = null;
  let checkOutDate = null;

  $('#dateRange').daterangepicker({
    opens: 'right',
    minDate: moment(),
  }, function(start, end) {
    checkInDate = start.format('YYYY-MM-DD');
    checkOutDate = end.format('YYYY-MM-DD');
  });

  document.getElementById('bookingForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const userId = 1; // default test user

    if (!checkInDate || !checkOutDate) {
      alert("Please select check-in and check-out dates.");
      return;
    }

    try {
      // Check availability
      const res = await fetch(`http://localhost/seproject/backend/bookings/check/${accommodationId}`);
      const existingBookings = await res.json();

      const conflict = existingBookings.some(b => {
        const bookedStart = new Date(b.checkInDate);
        const bookedEnd = new Date(b.checkOutDate);
        const userStart = new Date(checkInDate);
        const userEnd = new Date(checkOutDate);
        return (userStart < bookedEnd && userEnd > bookedStart);
      });

      if (conflict) {
        alert("❌ Selected dates are already booked for this accommodation.");
        return;
      }

      const bookingData = {
        userId,
        accommodationId: parseInt(accommodationId),
        checkInDate,
        checkOutDate
      };

      const postRes = await fetch('http://localhost/seproject/backend/bookings', {
        method: 'POST',
        headers: {
  'Authorization': 'guest-token', // just anything to bypass
  'Content-Type': 'application/json'
},
        body: JSON.stringify(bookingData)
      });

      if (!postRes.ok) throw new Error(await postRes.text());

      document.getElementById('bookingForm').innerHTML = `
  <div class="alert alert-success text-center">
    ✅ Your booking was successful! Thank you for choosing BooknStay.
  </div>
  <div class="text-center mt-3">
    <a href="services.html" class="btn btn-primary">Back to Accommodations</a>
  </div>
`;


    } catch (err) {
      console.error("❌ Booking failed:", err);
      alert("❌ Booking failed: " + err.message);
    }
  });
});
