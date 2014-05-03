/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
* 
* 站长图库 - http://www.zztuku.com
*
* @author Roddy <fmamcn@vip.qq.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('runCode', function(K) {
	var self = this, name = 'runCode';
	self.clickToolbar(name, function() {
		var lang = self.lang(name + '.'),
			html = ['<div style="padding:10px 20px;">',
				'<textarea class="ke-textarea" style="width:408px;height:260px;"></textarea>',
				'<dr />',
				'站长图库 - <a href="http://www.zztuku.com" target="_blank">http://www.zztuku.com</a>',
				'</div>'].join(''),
			dialog = self.createDialog({
				name : name,
				width : 450,
				title : self.lang(name),
				body : html,
				yesBtn : {
					name : self.lang('yes'),
					click : function(e) {
						var type = K('.ke-code-type', dialog.div).val(),
							code = textarea.val(),
							cls = type === '' ? '' :  ' lang-' + type,
							html = '<p><textarea name="runcode0" style="width:600px;height:220px;" cols="80″ rows="15">\n' + K.escape(code) + '</textarea><br><input type="button" value="运行代码" class="btn02" onMouseOver="this.className="btn04" onMouseOut="this.className="btn02" onClick="runCode(runcode0)">&nbsp;<input type="button" value="复制代码" class="btn02" onMouseOver="this.className="btn04" onMouseOut="this.className="btn02" onClick="copycode(runcode0)">&nbsp;<input type="button" value="另存代码" class="btn02" onMouseOver="this.className="btn04" onMouseOut="this.className="btn02"  onClick="saveCode(runcode0)">&nbsp;<span style="color:#999999; font-size:12px;">提示：您可以先修改部分代码再运行</span></p>';
						self.insertHtml(html).hideDialog().focus();
					}
				}
			}),
			textarea = K('textarea', dialog.div);
		textarea[0].focus();
	});
});
