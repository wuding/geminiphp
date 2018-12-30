<?php $this->layout('aero/chplayer', ['title' => 'User Profile']) ?>

<form action="/s?debug" method="get">
	<input name="q" value="<?=$this->e($url)?>" style="width: 60%">
	<input type="hidden" name="debug" value="">
	<button type="submit">&nbsp; &crarr; &nbsp;</button>
</form>

<div id="video" style="width: 800px; height: 450px;"></div>
<script type="text/javascript">
var url = '<?=$url?>';
var videoObject = {
	container: '#video', //容器的ID或className
	variable: 'player',
	volume: 0.6, //默认音量
	poster: 'http://www.91zy.cc/pic/up_lotoii1img/2018-6/15301694489.jpg', //封面图片地址https://img3.doubanio.com/view/photo/raw/public/p2496386806.jpg
	autoplay: true, //是否自动播放
	loop: false, //是否循环播放
	live: false, //是否是直播
	//loaded: 'loadedHandler', //当播放器加载后执行的函数
	seek: 0, //默认需要跳转的时间
	drag: '', //在flashplayer情况下是否需要支持拖动，拖动的属性是什么
	front: '', //前一集按钮动作frontFun
	next: '', //下一集按钮动作nextFun
	//flashplayer: true, //强制使用flashplayer
	//html5m3u8:true,//是否使用hls，默认不选择，如果此属性设置成true，则不能设置flashplayer:true,
	/*chtrack: {
		src: 'http://localhost/player/chplayer-master/screenshot/srt.srt',
		charset: 'utf-8'
	}, //字幕文件及编码*/
	video:[
		[url,'','',0]
	]
};

var player = new chplayer(videoObject);// 
</script>
