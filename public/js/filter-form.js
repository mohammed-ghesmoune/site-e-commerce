document.querySelectorAll('#colorSection .form-check-label').forEach(element => {
	const content = element.innerHTML
	const style = 'width:25px ; height:25px'
	element.innerHTML = `<input type='color' value='${content}' style='${style}'disabled />`
})

function resetFilterForm() {
	document.querySelectorAll('#filter-form input[type="checkbox"]').forEach(checkbox => {
		checkbox.removeAttribute('checked')
	})
}


(function filterFunction() {
	// show filter form sidbar
	$('#openFilterFormButton').click(function () {
		$("#filterForm").css('width', '100%');

	});
	$('#closeFilterFormButton').click(function () {

		$("#filterForm").css('width', '0');

	});

	$("#filterForm").click(function (event) {
		if (event.target == this) {
			$(this).css('width', '0');
		}
	})

	
	const loader = document.querySelector('.loader')

	function filterSortFetch(url) {
		loader.classList.remove('d-none')
		fetch(url, {
			method: 'get',
			headers: {
				"X-Requested-With": "XMLHttpRequest",
				"Content-Type": "application/x-www-form-urlencoded"
			}
		})
			.then(response => response.json())
			.then(data => {
				document.querySelector('#list-product').innerHTML = data.content
				loader.classList.add('d-none')
				filterFunction()
			})
			.catch(error => console.warn(error))
	}


	document.querySelector('#filter-form').addEventListener('submit', function (event) {
		event.preventDefault();
		const formData = new FormData(this)
		const queryString = new URLSearchParams(formData).toString();
		const url = `${this.getAttribute('action')}?${queryString}`

		document.querySelector("#filterForm").style.width = 0;
		history.pushState({},null,url)
		filterSortFetch(url)
	})

	document.querySelectorAll('#sort-products a , .pagination .page-link').forEach(element => {
		element.addEventListener('click', function (event) {
			event.preventDefault();
			const url = this.href
			history.pushState({},null,url)
			filterSortFetch(url)
		})
	})
	
	
})();
