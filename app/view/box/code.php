<?php
$this->AddReady('$(".fadeCode .textboxXXL")[0].addEventListener("paste", main.PastleUnformat); $("#saveCode").click(function() {main.FormatSaveCode("#codeForm", "#formatBox"); });');
?>
<div class="fadeCode">
	<div class="head"><div>Вставка кода</div><i class="fa fa-times" onclick="main.HideFade()"></i></div>
	<div id="codeForm" class="body settings short">
		<input type="hidden" name="id" value="<?= $code ? $code->id : 0 ?>" />
		<div>
			<label>Название</label>
			<div><input type="text" name="name" <?= $code ? 'value="' . $code->name . '"' : ''?>><div class="tip"></div></div>
		</div>
		<div>
			<label>Тип</label>
			<div>
				<select name="type">
					<option value="0" <?= ($code && $code->type == 0) ? 'selected="selected"' : ''?>>Обычное форматирование</option>
					<option value="1" <?= ($code && $code->type == 1) ? 'selected="selected"' : ''?>>C++</option>
				</select>
			</div>
		</div>
		<div>
			<label>Номер начальной строки</label>
			<div><input type="text" name="number" value="<?= $code ? $code->number : '1'?>"><div class="tip"></div></div>
		</div>
		<div>
			<label>Фрагмент кода<span>*</span></label>
			<div><textarea class="textbox textboxXXL" onkeydown="dc.InsertTab(event)" style="font-family: monospace!important;" name="content"><?= $code ? $code->content : ''?></textarea></div>
		</div>
		<div class="settingsM">
			<button id="saveCode">Сохранить</button>
		</div>
	</div>
</div>