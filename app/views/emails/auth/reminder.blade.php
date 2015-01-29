<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>

		<div>
		    Hello!
			To reset your password at http://android-libs.com, complete this form: {{ URL::to('password/reset', [$token]) }}.
		</div>
	</body>
</html>
