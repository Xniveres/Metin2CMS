<?php
	$lastVersion = officialVersion();
	$failed = '<div class="alert alert-danger" role="alert">'.$lang['not-updated'].': <a href="https://new.metin2cms.cf/v2/'.$lastVersion.'.zip" class="tag tag-success">'.$lang['update'].'</a></div>';
	
	if(checkUpdate($lastVersion))
	{
		if(isset($_POST['update']))
		{
?>
	<center><img src="<?php print $site_url; ?>images/site/updating.gif"></center></br>
<?php
	$file = 'update.zip';
	@file_put_contents($file, file_get_contents('https://new.metin2cms.cf/v2/'.$lastVersion.'.zip'));

	if(file_exists($file)) {
		$path = pathinfo(realpath($file), PATHINFO_DIRNAME);

		$zip = new ZipArchive;
		$res = $zip->open($file);
		if($res === TRUE) {
			$zip->extractTo($path);
			$zip->close();
			
			if(file_exists($file)) {
				unlink($file);
			}
			
			print "<script>top.location='".$site_url."admin'</script>";
		} else {
			print $failed;
		}
	} else print $failed;
	
} else { ?>
	<div class="alert alert-info" role="alert">
		<h4 class="alert-heading"><?php print $lang['update-available']; ?>!</h4>
		<p><?php print $lang['update-info']; ?></p>
		
		<form action="" method="post">
			<input type="submit" name="update" class="btn btn-success btn-lg btn-block" value="<?php print $lang['update']; ?>" />
		</form>
		
	</div>
<?php
		}
	} else 
	{
		$helloworld = @file_get_contents('http://metin2cms.cf/salut.php?lang='.$language_code);
		if($helloworld)
			print '<div class="alert alert-info alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$helloworld.'</div>';
	}
?>


