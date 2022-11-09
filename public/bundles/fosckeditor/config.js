/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.uiColor = '#d6d6d6';
	config.width = '100%';
	config.height = '40em';
	config.editorplaceholder = 'Rédiger votre texte ici…';
	//config.image2_alignClasses = [ 'align-left', 'align-center', 'align-right' ];
	
};
CKEDITOR.on( 'instanceReady', function( evt ) {
	evt.editor.dataProcessor.htmlFilter.addRules( {
	  elements: {
		img: function(el) {
		  el.addClass('img-fluid');
		}
	  }
	});
});
