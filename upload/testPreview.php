<?php include("testPreviewHeader.php") ; ?>
<div class="container-fluid mt-5">
	<div class="row">
		<div class="iframe-container-100">
			<iframe class="myIframe" src="<?php echo $demoLink."?cachebust=1" ; ?>" noresize="noresize" scrolling="yes"></iframe>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_URL ; ?>js/main.js"></script>
</body>
</html>
