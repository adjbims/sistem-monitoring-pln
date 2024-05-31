
setInterval(() => {
  fetch('/api/notify', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok.');
      }
      return response.json();
    })
    .then(data => {
      if (data.message === 'Folder berhasil dihapus karena sudah melewati tanggal dan waktu yang ditentukan') {
        alert(data.message);
      }
    })
    .catch(error => {
      console.error('Fetch error:', error);
    });
}, 2000);
