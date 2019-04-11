<?php
$this->addReady('vUpdate.items = ' . json_encode($files));
?>
<div class="row" v-for="(item, index) in items">
	<div class="name">{{item.name}}</div>
	<div class="red"><i class="fa fa-times" v-if="item.val" v-on:click="Delete(index)"></i><i class="fa fa-minus-circle" v-if="!item.val" v-on:click="Down(index)"></i></div>
</div>