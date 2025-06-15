export const userService = {
  getAllUsers: async () => {
    const token = localStorage.getItem('jwt') || '';
    const response = await fetch("http://localhost/seproject/backend/users", {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });

    if (!response.ok) {
      const errorText = await response.text();
      throw new Error(errorText);
    }

    return await response.json();
  }
};
