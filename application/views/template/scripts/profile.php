<script type="text/javascript">
	$(function() {
		$('#change-password').submit(function(e) {
			e.preventDefault();
			let form_data = $(this).serialize();
			let url = BASEURL + 'Login/changePasswordPost';
			$('#inputNewPassword').val();
			$('#inputConfirmPassword').val();
			let status = matchPassword($('#inputNewPassword').val(), $('#inputConfirmPassword').val());
			if (status) {
				$.post(url, form_data, function(data) {
					data=JSON.parse(data);
					data.type=='success'?successAlert(data.message):errorAlert(data.message);
					
				});
			}else{
				errorAlert('Password did not match');
			}



		});
	});

	const matchPassword = (newpassword, confirmpassword) => {

		if (newpassword != confirmpassword) {
			return false;
		} else {
			return true;
		}
	}
</script>