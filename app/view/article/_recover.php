<?php
	use core\dc\DC;
	$this->AddReady('$(".ref[data-type=\'article\']").click(function() {article.Delete(1);});');
	$this->AddReady('$(".ref[data-type=\'article-hide\']").click(function() {article.Delete(2);});');
?>
<div class="center">
	<div>Статья удалена</div>
	<div><span class="ref" data-type="article">Восстановить</span> | <span class="ref" data-type="article-hide">Восстановить как черновик</span></div>
</div>