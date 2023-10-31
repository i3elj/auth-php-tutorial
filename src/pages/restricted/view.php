<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Auth System - Users Only!</title>
	<link rel="stylesheet" type="text/css" href="./globals.css">
	<link rel="stylesheet" type="text/css" href="./src/pages/restricted/style.css">
</head>

<body>
	<main>
		<?php if ($is_logged) : ?>

			<h1 class="title">Welcome back <?= $userid ?>!</h1>

		<?php else : ?>

			<div>
				<h1 class="title">
					Sorry, you're not allowed to be here
				</h1>
				<h3 class="subtitle">
					You'll be redirected in
					<span id="counter">10...</span>
				</h3>

				<script type="text/javascript">
					let counter = document.querySelector("#counter")
					let i = 10
					setTimeout(() => {
						let id = setInterval(() => {
							i -= 1
							counter.innerText = `${i}...`
						}, 1000)
						setTimeout(() => {
							clearInterval(id)
							document.location = 'http://localhost:3000/'
						}, 10_000)
					}, 900)
				</script>
			</div>

		<?php endif; ?>
	</main>
</body>

</html>
