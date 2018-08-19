
const softwares = document.getElementById('software');

if (softwares) {
  softwares.addEventListener('click', e => {
    if (e.target.className === 'btn btn-danger delete-article') {
      if (confirm('Are you sure?')) {
        const id = e.target.getAttribute('data-id');

        fetch(`/software/delete/${id}`, {
          method: 'DELETE'
        }).then(res => window.location.reload());
      }
    }
  });
}