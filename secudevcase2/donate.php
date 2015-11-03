<!DOCTYPE html>
<html lang = "en">
<head>
	
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<form action="payment.php" method="POST">
	<select name="amount">
		<option value="5">5</option>
		<option value="10">10</option>
		<option value="20">20</option>
	</select>
	<select name="currency">
		<option value="USD">USD</option>
	</select>
	<input type="hidden" name="description" value="Donation"><br><br><br>
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<!-- <input type=submit value="Paypal Donate"> -->
</form>
</body>
</html>
