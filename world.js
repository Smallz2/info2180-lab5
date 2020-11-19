"use strict";


window.onload = function() {
	main()

}

function main() {
	var search_button = document.querySelector("#lookup-country");
	var reset_button = document.querySelector("#lookup-reset");
	var city_button = document.querySelector("#lookup-city");
	fetchData()

	search_button.addEventListener("click", function() {
		fetchData(event, 'search_country')
	});
	city_button.addEventListener("click", searchCities)
	reset_button.addEventListener("click", resetSearch)
}

function searchCities(event) {
	console.log("hello")
	if (document.querySelector("#country").value == "") {
		alert("country can't be blank");
		return;
	}

	fetchData(event, 'search_country_city')
}

function resetSearch(event) {
	document.querySelector("#country").value = '';
	fetchData(event, '')
}

function fetchData(event, calltype) {
	var search_input = document.querySelector("#country").value;
	
	try {
		var fetch_url = './world.php';
		var params = "";
		var url_params = "";
	
		if (calltype == "search_country") {
			params = { country: `${search_input}` }
			url_params = new URLSearchParams(Object.entries(params));
			fetch_url = './world.php?' + url_params;
		} else if (calltype == "search_country_city") {
			params = { country: `${search_input}`, context: 'cities' }
			url_params = new URLSearchParams(Object.entries(params));
			fetch_url = './world.php?' + url_params;
		}

		fetch(fetch_url)
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