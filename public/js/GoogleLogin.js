let URLROOT2 = 'https://localhost/evCalendar';

function checkAndReg(userEmail, userName) {
	let formData = new FormData();
	formData.append('email', userEmail);

	let request = new XMLHttpRequest();
	request.open('POST', URLROOT2 + '/users/googleLogin');
	request.send(formData);
	request.onreadystatechange = function() {
		if (request.readyState == XMLHttpRequest.DONE) {
			const serverResp = JSON.parse(request.responseText);
			if (serverResp.success) {
				window.location = URLROOT2 + '/';
				return;
			}
			//if mail is not found on my db

			if (response.name) {
				let userFormData = new FormData();
				userFormData.append('name', userName);
				userFormData.append('email', userEmail);
				let regRequest = new XMLHttpRequest();
				regRequest.open('POST', URLROOT + '/users/googleRegUser');
				regRequest.send(userFormData);
				regRequest.onreadystatechange = function() {
					if (regRequest.readyState == XMLHttpRequest.DONE) {
						const serverResp = JSON.parse(regRequest.responseText);
						if (serverResp.success) {
							window.location = URLROOT2 + '/users/login';
							return;
						}
					}
				};
			}
		}
	};
}

function onSignIn(googleUser) {
	let profile = googleUser.getBasicProfile();
	let userEmail = profile.getEmail();
	let userName = profile.getName();
	//if user is logged in google
	if (userEmail && userName) {
		//now check he is registered on my db
		checkAndReg(userEmail, userName);
	}
	// console.log(userEmail);
	// console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	// console.log('Name: ' + profile.getName());
	// console.log('Image URL: ' + profile.getImageUrl());
	// console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
