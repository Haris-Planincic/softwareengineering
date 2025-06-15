document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contact-form');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    const data = {
      firstName: document.getElementById('fname').value.trim(),
      lastName: document.getElementById('lname').value.trim(),
      email: document.getElementById('email').value.trim(),
      message: document.getElementById('message').value.trim()
    };

    try {
      const response = await fetch('http://localhost/seproject/backend/contacts', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
      });

      if (!response.ok) {
        const errorText = await response.text();
        throw new Error(errorText || 'Failed to send message.');
      }

      const result = await response.json();
      alert('✅ Message sent successfully!');
      form.reset();

    } catch (error) {
      console.error('❌ Error:', error);
      alert('❌ Error sending message: ' + error.message);
    }
  });
});
