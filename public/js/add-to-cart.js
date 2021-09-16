(function colorSizeFunction() {
 	 //const quantity = document.querySelector('.quantityValue')
	const quantityInput = document.querySelector('input[name="order[quantity]"]')
	let quantityValue = parseInt(quantityInput.value)
	document.querySelector('.decrement').addEventListener('click', e=>{
			console.log(quantityValue)
			if(quantityValue > 1){
				
				quantityInput.value = --quantityValue;
				//quantity.innerHTML=quantityValue;
			}
		
	})
	document.querySelector('.increment').addEventListener('click', e=>{
			console.log(quantityValue)
			quantityInput.value = ++quantityValue;
			//quantity.innerHTML=quantityValue;

		
	})

	
	const productDetails = document.querySelector('.show')
	const loader = document.querySelector('.loader')
	document.querySelectorAll('.btn-color, .btn-size, .btn-img').forEach(btn => {
		btn.addEventListener('click', (event) => {
			event.preventDefault();
			const url = event.currentTarget.href
			window.history.pushState({}, '', url);
			loader.classList.remove('d-none')

			fetch(url, {
				headers: {
					"X-Requested-With": "XMLHttpRequest"
				}
			}).then(response => {
				response.json().then(data => {
					
					productDetails.innerHTML = data.content
					colorSizeFunction()
					loader.classList.add('d-none')
				})
			}).catch(error => console.warn(error))
		})
	})
	const form = document.querySelector('form[name="order"]');
	form.addEventListener('submit', function (e) {
		e.preventDefault()
		const url = this.getAttribute('action')
		const formData = new FormData(this)
		const redirect = this.dataset.redirect

		loader.classList.remove('d-none')

		fetch(url, {
			method: 'post',
			body: formData,
			headers: {
				"X-Requested-With": "XMLHttpRequest"
			}
		}).then(response => {
			if (response.headers.get('content-type').startsWith('text/html')) {
				window.location.href = redirect
				loader.classList.add('d-none')

			} else {
				return response.json().then(data => {
					productDetails.innerHTML = data.content
					colorSizeFunction()
					loader.classList.add('d-none')
					
				})
			}

		}).catch(error => console.warn(error))

	})
})()
