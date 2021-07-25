document.addEventListener("DOMContentLoaded", () => {

  const body = document.querySelector('body');

  body.addEventListener('click', function (e) {
    if (e.target.classList.contains('page-numbers')) {
      e.preventDefault();

      const link = e.target,
        page = link.textContent,
        formData = new FormData(),
        wrapper = link.parentElement;

      formData.append('action', 'do_pagination');
      formData.append('_ajax_nonce', pag_obj_js.nonce);
      formData.append('page', page);

      fetch(pag_obj_js.admin_url, {
        method: 'POST',
        body: formData,
      })
        .then((response) => response.json())
        .then((response) => {
          wrapper.innerHTML = response.data;
        })
    }
  })

});


