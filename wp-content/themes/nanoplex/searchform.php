<form class="form searchform" role="search" method="get" action="<?php echo home_url( '/' ); ?>" > 
	<fieldset class="search">
		<input type="text" class="box inputsearch" name="s" />
		<!--IF YOU WANT VOICE SEARCH (IT WON'T VALIDATE) USE THIS INSTEAD: <input type="text" class="box" name="s" id="search" x-webkit-speech speech onwebkitspeechchange="this.form.submit();"/>-->
		<button class="btn" title="Submit Search"></button>
	</fieldset>
</form>

