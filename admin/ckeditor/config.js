/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard', groups: ['clipboard', 'undo'] },
		{ name: 'editing', groups: ['find', 'selection', 'spellchecker'] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'tools' },
		{ name: 'document', groups: ['mode', 'document', 'doctools'] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
		{ name: 'paragraph', groups: ['align', 'list', 'indent', 'blocks', 'bidi'] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'tools' },
		{ name: 'others' }
	];


	config.extraPlugins = 'widgetselection,lineutils,dialog,dialogui,btgrid,bootstrapTabs,accordionList,collapsibleItem,lightbox,youtube,justify,colorbutton,panelbutton,floatpanel,font,colordialog,ckawesome,basewidget,layoutmanager';
	config.extraAllowedContent = 'a[data-lightbox,data-title,data-lightbox-saved]';
	config.allowedContent = true;
	config.protectedSource.push(/<\?[\s\S]*?\?>/g);
	config.fontawesomePath = 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
};
