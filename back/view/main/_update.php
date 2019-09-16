<?php
$this->addReady('$(".updates .fa-times").click(function() {upd.Delete(this);});');
$this->addReady('$(".updates .fa-minus-circle").click(function() {upd.Down(this);});');
foreach($files as $name => $val): ?>
<div class="row">
	<div class="name"><?= $name ?></div>
	<div class="<?= $val ? 'red' : 'green' ?>"><i class="fa fa-<?= $val ? 'times': 'minus-circle' ?>"></i></div>
</div><?php
endforeach ?>
