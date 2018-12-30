<?php $this->layout('aero/layout', ['title' => 'User Profile']) ?>

<form action="/s?debug" method="get" onsubmit="return play();">
	<input name="q" value="<?=$this->e($url)?>" style="width: 60%" id="url" placeholder="请输入m3u8地址">
	<input type="hidden" name="debug" value="">
	<button type="submit">&nbsp; &crarr; &nbsp;</button>
</form>
<div id="video" style="width: 100%; max-width: 800px; height: 450px;    margin: 0 auto;"></div>
<script>
var url = '';
var obj = {
	container: '#video',
	variable: 'player',
	video:[
		[ url, '', '', 0 ]
	]
};
var player;

function play() {
	url = document.getElementById( 'url' ).value;
	obj.video[0] = [ url, '', '', 0 ];
	console.log( JSON.stringify( obj ) );
	player = new chplayer( obj ); // 
	return false;
}

if (document.getElementById( 'url' ).value) {
	play();
}
</script>
