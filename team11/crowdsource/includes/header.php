<header>
	<div id="logo">
		<a href="index.php">AccountabiliBuddies</a>
	</div>
	<?php
		if (login_check($db) == true) {
			include('headerlinks2.php');
		} else {
			include('headerlinks1.php');
		}

	?>
</header>
