
function profileHandler() {
	const loader = document.querySelector('.loader')

	document.querySelectorAll('.changePersonalInformations, .changeContactInformations, .changeEmail, .changePassword, .changeAddress').forEach(form => {
		form.addEventListener('submit', function (event) {
			event.preventDefault();
			const form = this;
			const form_url = this.getAttribute("action");
			const form_method = this.getAttribute("method");
			const form_data = new FormData(this);
			loader.classList.remove('d-none')

			fetch(form_url, {
				method: form_method,
				body: form_data,
				headers: {
					"X-Requested-With": "XMLHttpRequest"
				}
			}).then(response => response.json())
				.then(data => {
					if (form.classList.contains('changePersonalInformations')) {
						document.getElementById('personalInformations').innerHTML = data.content;
					}
					if (form.classList.contains('changeContactInformations')) {
						document.getElementById('contactInformations').innerHTML = data.content;
					}
					if (form.classList.contains('changeEmail')) {
						document.getElementById('emailInformations').innerHTML = data.content;
					}
					if (form.classList.contains('changePassword')) {
						document.getElementById('passwordInformations').innerHTML = data.content;
					}
					if (form.classList.contains('changeAddress')) {
						document.getElementById('addressInformations').innerHTML = data.content;
					}
					profileHandler()
					deleteAddress()
					loader.classList.add('d-none')
				//	console.log(document.querySelector(`form[name=${form.getAttribute('name')}]`))
					const newForm = document.querySelector(`form[name=${form.getAttribute('name')}]`)
					newForm.parentElement.firstElementChild.classList.remove('show')
				  newForm.classList.add('show')
				

				})
				.catch(error => console.warn(error))

		})

	});
};

function deleteAddress() {
	const loader = document.querySelector('.loader')

	document.querySelectorAll('.deleteAddress').forEach(element => {
		element.addEventListener('click', function (event) {
			event.preventDefault();
			const formData = new FormData();
			formData.append('delete_address', this.dataset.address)
			loader.classList.remove('d-none')

			fetch('/profile', {
				method: 'post',
				body: formData,
				headers: {
					"X-Requested-With": "XMLHttpRequest"
				}
			}).then(response => response.json())
				.then(data => {
					document.getElementById('addressInformations').innerHTML = data.content;
					deleteAddress()
					profileHandler()
					loader.classList.add('d-none')

				})
				.catch(error => console.warn(error))

		})
	})

}
profileHandler()
deleteAddress()

