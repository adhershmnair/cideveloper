<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

function text_editor($data){


	$id 	= (!empty($data['id'])) ? $data['id'] : 'textarea' ;
	$value 	= (!empty($data['value'])) ? $data['value'] : 'textarea' ;
	$skin 	= (!empty($data['skin'])) ? $data['skin'] : 'moono-lisa' ;

    $textarea = '<textarea cols="80" id="'.$id.'" name="'.$id.'" rows="10">'.$value.'</textarea>';
    return $textarea."<script type='text/javascript'>
jQuery(document).ready(function(){
var editor".$id." = CKEDITOR.replace( '".$id."' ,{
toolbar : [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', '-', 'SelectAll' ] },
	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar',  'Iframe' ] },
	'/',
	{ name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	{ name: 'others', items: [ '-' ] },
	
],
toolbarGroups : [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'forms' },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	{ name: 'links' },
	{ name: 'insert' },
	'/',
	{ name: 'styles' },
	{ name: 'colors' },
	{ name: 'tools' },
	{ name: 'others' },
	{ name: 'about' }
],
toolbarCanCollapse : true,
skin : '".$skin."',
filebrowserBrowseUrl: '/assets/plugins/richfilemanager/index.html',
filebrowserImageBrowseUrl: '/assets/plugins/richfilemanager/index.html?type=Images',

}
);

CKEDITOR.on('dialogDefinition', function (event)
	    {
	        var editor = event.editor;
	        var dialogDefinition = event.data.definition;
	        var dialogName = event.data.name;

	        var cleanUpFuncRef = CKEDITOR.tools.addFunction(function ()
	        {
	            $('#fm-iframe').remove();
	            $('body').css('overflow-y', 'scroll');
	        });

	        var tabCount = dialogDefinition.contents.length;
	        for (var i = 0; i < tabCount; i++) {
	            var browseButton = dialogDefinition.contents[i].get('browse');

	            if (browseButton !== null) {
	                browseButton.hidden = false;
	                browseButton.onClick = function (dialog, i)
	                {
	                    editor._.filebrowserSe = this;
	                    var iframe = $('<iframe id=fm-iframe class=fm-modal/>').attr({
	                        src: '/assets/plugins/richfilemanager/index.html' + 
	                            '?CKEditorFuncNum=' + CKEDITOR.instances[event.editor.name]._.filebrowserFn +
	                            '&CKEditorCleanUpFuncNum=' + cleanUpFuncRef +
	                            '&langCode=en-gb' +
	                            '&CKEditor=' + event.editor.name
	                    });

	                    $('body').append(iframe);
	                    $('body').css('overflow-y', 'hidden'); 
	                }
	            }
	        }
	    }); 


	});
</script>
<style>
.fm-modal {
	z-index: 10011; /** Because CKEditor image dialog was at 10010 */
	width:80%;
	height:80%;
	top: 10%;
	left:10%;
	border:0;
	position:fixed;
	-moz-box-shadow: 0px 1px 5px 0px #656565;
	-webkit-box-shadow: 0px 1px 5px 0px #656565;
	-o-box-shadow: 0px 1px 5px 0px #656565;
	box-shadow: 0px 1px 5px 0px #656565;
	filter:progid:DXImageTransform.Microsoft.Shadow(color=#656565, Direction=180, Strength=5);
}
</style>
";
}

/*
//COPIED FROM VARIOUS SOURCES BY ADHERSH M NAIR
toolbar : [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
	{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
	'/',
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	{ name: 'others', items: [ '-' ] },
	{ name: 'about', items: [ 'About' ] }
],

toolbarGroups : [
	{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
	{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
	{ name: 'forms' },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
	{ name: 'links' },
	{ name: 'insert' },
	'/',
	{ name: 'styles' },
	{ name: 'colors' },
	{ name: 'tools' },
	{ name: 'others' },
	{ name: 'about' }
]

*/