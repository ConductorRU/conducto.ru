<?php
use core\dc\DC;
?>
<!DOCTYPE html>
<html lang="ru-RU">
	<head>
		<meta charset="utf-8">
		<title><?= $this->title ?></title>
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<?= $this->head() ?>
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({
				google_ad_client: "ca-pub-1690770305920382",
				enable_page_level_ads: true
			});
		</script>
		<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter46869813 = new Ya.Metrika({ id:46869813, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/46869813" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
	</head>
	<body>
	<?php $this->beginBody() ?>
		<div id="app" class="wrap">
			<page class="main">
				<div id="content"><?= $content ?></div>
			</page>
			<footer></footer>
		</div>
	<?php $this->endBody() ?>
	</body>
</html>