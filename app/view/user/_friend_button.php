<?php
use app\model\Friend;
if(!$friend || $friend->status == Friend::STATUS_CANCEL): ?><div class="sFriend"><button class="blu" onclick="main.AddFriend(this, <?= $user_id ?>, 1);" data-wait="Подождите...">Добавить в друзья</button></div><?php
elseif($friend->status == Friend::STATUS_MUTUAL): ?><div class="sFriend">В друзьях</div><?php
elseif($friend->status == Friend::STATUS_SUBSCRIBE): ?><div class="sFriend" onmouseover="$(this).find('.hov').stop().fadeIn(300)" onmouseout="$(this).find('.hov').stop().fadeOut(300)">Заявка отправлена<div class="hov"><div><button onclick="main.AddFriend(this, <?= $user_id ?>, 0);" data-wait="Подождите...">Отменить</button></div></div></div><?php
endif;