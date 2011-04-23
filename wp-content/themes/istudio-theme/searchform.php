<?php if(istOption('googleSearch')&&istOption('googleId')){$gSearch=istOption('googleId');}else{$gSearch=NULL;}
if($gSearch){?>
<form id="searchform" class="search" action="http://www.google.com/cse" method="get">
	<div><input type="text" class="search_text" name="q" size="24" onblur="if(this.value=='')this.value='Search...';this.className='search_text';" onfocus="this.value='';this.className='search_textfocus';"onclick="if(this.value=='Search...')this.value=''" value="Search..."  />
  <input type="submit" name="sa" value="" class="search_submit" onmousemove="this.className='search_submithover'" onmousedown="this.className='search_submitactive'" onmouseout="this.className='search_submit'" />
  <input type="hidden" name="cx" value="<?php echo $gSearch;?>" />
  <input type="hidden" name="ie" value="UTF-8" /></div>
</form>
<?php }else{?>
<form method="get" id="searchform" class="search" action="<?php echo home_url('/');?>">
	<div><input name="s" type="text" id="s" onblur="if(this.value =='')this.value='Search...';this.className='search_text';" onfocus="this.value='';this.className='search_textfocus';" onclick="if(this.value=='Search...')this.value=''" value="Search..." class="search_text" />
  <input type="submit" name="button" id="button" value="" class="search_submit" onmousemove="this.className='search_submithover'" onmousedown="this.className='search_submitactive'" onmouseout="this.className='search_submit'" /></div>
</form>
<?php }?>