<?php
$greeting = 'ස්තූතියි!';
$msg = 'ඔබගේ පැමිණිල්ල බාරගන්නා ලදී.';
$btnText = 'වෙනත් පැමිණිල්ලක් කරන්න';
$page = 'sinhala.php';
include "dbAccess.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Li - Fix</title>
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="../assets/favicon/site.webmanifest">
	<link rel="stylesheet" type="text/css" href="../css/complainer/style.css">
	<script src="../js/jquery-3.5.1.min.js"></script>
	<script src="../js/jquery.color-2.1.2.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
</head>

<body>
	<div class="container">
		<section>
			<a id="lan" class="floating-btn">සිං</a>
		</section>
		<div class="contact-box">

			<div class="left"></div>
			<div class="right">
				<h2>පැමිණිලි</h2>
				<form action="sinhala.php" method="POST" class="contact-us">
					<input type="text" name="name" value="<?php echo htmlspecialchars($name) ?>" class="field <?php if ($errors['name']) echo "err"; ?>" placeholder="<?php if ($errors['name']) echo 'නිවැරදි නම යොදන්න';
																																									else echo 'නම'; ?>">
					<input type="text" name="nic" value="<?php echo htmlspecialchars($nic) ?>" class="field <?php if ($errors['nic']) echo "err"; ?>" placeholder="<?php if ($errors['nic']) echo 'නිවැරදි හැඳුනුම්පත් අංකය යොදන්න';
																																									else echo 'හැඳුනුම්පත් අංකය'; ?>">
					<div class="box">
						<div class="p-left">
							<input type="text" name="lampid" value="<?php echo htmlspecialchars($lampId) ?>" class="field <?php if ($errors['lampid']) echo "err"; ?>" placeholder="<?php if ($errors['lampid']) echo 'කණු අංකය යොදන්න';
																																													else echo 'පහන් කණු අංකය'; ?>">
						</div>
						<div class="bulb">
							<span><label for="bulb">බල්බය තිබේද? </label><input class="checkmark" type="checkbox" name="bulb" id="bulb" value="yes"></span>
						</div>
					</div>
					<input type="text" name="note" value="<?php echo htmlspecialchars($note) ?>" class="field note" placeholder="අමතර විස්තර">
					<div class="box">
						<div class="p-left">
							<input type="text" name="phone" value="<?php echo htmlspecialchars($phoneNo) ?>" class="field <?php if ($errors['phone']) echo "err"; ?>" placeholder="<?php if ($errors['phone']) echo 'දුරකථන අංකය යොදන්න';
																																													else echo 'දුරකථන අංකය'; ?>" id="f5">
						</div>
						<div class="p-right">
							<button class="btn2" style="font-size:14px; padding: 0.7rem 1rem;">කේතය ගන්න</button>
						</div>
					</div>
					<input type="text" name="otp" class="field <?php if ($errors['otp']) echo "err"; ?>" value="<?php echo htmlspecialchars($otpCode) ?>" placeholder="<?php if ($errors['otp']) echo 'කේතය අත්‍යාවශ්‍ය වේ';
																																										else echo 'කේතය'; ?>" id="f6">
					<button name="submit" class="btn" id="submitBtn">පැමිණිලි කරන්න</button>

				</form>
			</div>
		</div>

	</div>

	<script src="../js/complainer/index.js"></script>
	<script src="../js/complainer/textBiz.js" defer></script>
</body>

</html>