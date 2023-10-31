<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./globals.css">
	<link rel="stylesheet" type="text/css" href="./src/pages/signup/style.css">
	<script src="https://unpkg.com/htmx.org@1.9.6"></script>
	<title>Auth System - Sign Up</title>
</head>

<body>
	<main>
		<form id="form_wrapper"
			hx-post="/signup" hx-trigger="submit"
			hx-target=".error" hx-swap="innerHTML"
		>
			<div id="username_field" class="input_field_wrapper">
				<label>User name:</label>
				<input id="name_input" class="input_field"
					type="text"
					name="name"
					required
				>
			</div>
			<div id="id_field" class="input_field_wrapper">
				<label>User id:</label>
				<input id="id_input" class="input_field"
					type="text"
					name="userid"
					required
				>
			</div>
			<div id="password_field" class="input_field_wrapper">
				<label>Password:</label>
				<input id="password_field" class="input_field"
					type="password"
					name="password"
					required
				>
			</div>
			<input type="submit" value="Submit">
			<p class="error"></p>
		</form>
	</main>
</body>

<script type="text/javascript">
	const form = document.querySelector("#form_wrapper")
	form.addEventListener("signup", function(event) {
		const response = event.detail
		if (response.success) {
			document.cookie = `token=${response.token}`
			document.cookie = `userid=${response.userid}`
			document.location = 'http://localhost:3000/restricted'
		}
	})
</script>

</html>
