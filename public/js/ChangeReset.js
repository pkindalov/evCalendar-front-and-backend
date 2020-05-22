let spinner = document.getElementById('spinnerRow');

document.addEventListener('DOMContentLoaded', function() {
    const URLROOT = 'https://192.168.0.125/evCalendar';
	spinner.style.display = 'none';

	//CHANGE PASSWORD
	const changePasswordForm = document.getElementById('changePasswordForm');
	if (changePasswordForm) {
		changePasswordForm.onsubmit = function() {
			return isValidForm();
		};
	}

	function isValidForm() {
		let oldPass = document.getElementById('oldPassword').value;
		let newPassword = document.getElementById('newPassword').value;
		let confirmNewPassword = document.getElementById('confirmNewPassword').value;
		let validationMessage = document.getElementById('validMessage');
		if (newPassword.length < 4) {
			validationMessage.innerText = 'New password is too short.';
			return false;
		}
		if (confirmNewPassword !== newPassword) {
			validationMessage.innerText = "Both passwords don't mach";
			return false;
		}
		return true;
	}

	//RESET PASSWORD
	const resetBtn = document.getElementById('resetBtn');
	resetBtn.addEventListener('click', function() {
		let closeBtn = document.getElementById('closeBtn');
		closeBtn.click();
		let email = document.getElementById('email').value;
		if (!email || email.length < 3 || email.indexOf('@') < 0) {
			let validMessage = document.getElementById('validMessage');
			validMessage.innerText = 'Email is not valid';
			return false;
		}

		let successSpan = document.getElementById('successResetPass');
		let formData = new FormData();
		formData.append('email', email);
		let request = new XMLHttpRequest();
		spinner.style.display = 'block';
		request.open('POST', `${URLROOT}/users/resetPassword`);
		request.send(formData);
		request.onreadystatechange = function() {
			if (request.readyState == XMLHttpRequest.DONE) {
				const serverResp = JSON.parse(request.responseText);
				if (serverResp.success) {
					spinner.style.display = 'none';
					successSpan.innerText = 'The password was reset successful. Email sent to ' + email;
					// window.location = `${URLROOT}/users/login`;
					// return;
				}
			}
		};
	});
});
