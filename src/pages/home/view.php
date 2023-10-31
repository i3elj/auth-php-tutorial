<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="./globals.css">
	<link rel="stylesheet" type="text/css" href="./src/pages/home/style.css">
	<script src="https://unpkg.com/htmx.org@1.9.6"></script>
	<title>Auth System - Login</title>
</head>

<body>
	<main>
		<div id="marketing">
			<h1>Welcome...</h1>
			<h3>Please, log in to continue.</h3>
		</div>

		<form id="form_wrapper"
			hx-post="/" hx-trigger="submit"
			hx-target="#login_error" hx-swap="innerHTML"
		>
			<p id="login_error"></p>
			<div id="id_field" class="input_field_wrapper">
				<label for="id_input">User id:</label>
				<input id="id_input" class="input_field"
					type="text"
					name="userid"
					required
				>
			</div>
			<div id="password_field" class="input_field_wrapper">
				<label for="password_input">Password:</label>
				<input id="password_input" class="input_field"
					type="password"
					name="password"
					required
				>
			</div>
			<input type="submit" value="Submit">
			<p id="signup_notice">
				Does not have an account yet?
				<a href="/signup">Sign up</a>
			</p>
		</form>
	</main>
</body>

<script type="text/javascript">
	const form = document.querySelector("#form_wrapper")
	form.addEventListener("login", function(event) {
		const response = event.detail
		if (response.success) {
			const date = new Date();
			date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000) /* a week in ms */)
			document.cookie = `token=${response.token};expires=${date.toUTCString()}`
			document.cookie = `userid=${response.userid};expires=${date.toUTCString()}`
			document.location = 'http://localhost:3000/restricted'
		}
	})
</script>

</html>
