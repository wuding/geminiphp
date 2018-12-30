<?php $this->layout('aero/layout', ['title' => 'User Profile']) ?>

<h1>deep</h1>
<form action="/s?debug" method="get">
	<input name="q" value="<?=$this->e($name)?>" style="width: 60%">
	<input type="hidden" name="debug" value="">
	<button type="submit">&nbsp; &crarr; &nbsp;</button>
</form>

