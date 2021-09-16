
(function registrationHandler() {
	const loader = document.querySelector('.loader')

	document.querySelectorAll('.securityForm').forEach(form => {
		form.addEventListener('submit', function (event) {
			event.preventDefault();
			const form = this;
			const form_url = this.getAttribute("action");
			const form_method = this.getAttribute("method");
      const form_data = new FormData(this);
      history.pushState({},null,form_url)
      //console.log(form_url)
			loader.classList.remove('d-none')

			fetch(form_url, {
				method: form_method,
				body: form_data,
				headers: {
					"X-Requested-With": "XMLHttpRequest"
				}
			}).then(response => response.json())
				.then(data => {
         document.querySelector('.securityWrapper').innerHTML= data.content
         registrationHandler()
         loader.classList.add('d-none')
				})
				.catch(error => console.warn(error))

		})

	});
})();



