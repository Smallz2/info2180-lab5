"use strict";


window.onload = function() {
	main()
}

function main() {
	var search_button = document.querySelector("#lookup");

	search_button.addEventListener('click', fetch_search);
}

function fetch_search(event) {
	var search_input = document.querySelector("#country").value;
	
	try {
		// Set url params
		var params = { country: `${search_input}` }
		var url_params = new URLSearchParams(Object.entries(params));

		fetch('./world.php?' + url_params)
			.then(
				function(response) {
					if (response.status !== 200) {
						console.log("Something went wrong. Status Code: " + response.status);
						return;
					}

					// Get the data from response and update UI
					response.text().then(function(promise) {
						updateUI(promise)
					});
				}
			)
			.catch(function(error) {
				console.error("fetching error: " + error);
			});
	} catch(error) {
		console.error(error);
	}
}

function updateUI(promise) {
	document.querySelector('#result').innerHTML = promise; 
}