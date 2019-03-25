<?php
	use core\dc\DC;
	$this->title = 'Чат';
?>
<div class="wSplit">
	<div class="wLeft">
		<div id="chat" class="messages">
			<chat :messages="messages"></chat>
		</div>
		<div class="mesBox">
			<div class="mesInput scroll" contenteditable>wewe</div>
		</div>
		<div class="mesActs">
			<span><i class="fa fa-paper-plane"></i></span>
		</div>
	</div>
	<div class="wRight scroll">
		<div class="eInfo">
			<div class="name">Чат</div>
		</div>
	</div>
</div>