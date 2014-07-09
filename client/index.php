<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Register</title>
	</head>
 
	<body>
		<form name="login" action="controllers/Login.php" method="post">
			<table width="510" border="0">
				<tr>
					<td colspan="2"><p><strong>Registration Form</strong></p></td>
				</tr>
				<tr>
					<td>NJIT ID:</td>
					<td><input type="text" name="user" maxlength="20" /></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="pass" name="pass" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>
	</body>
</html>
