(function() {
"use strict";  
 
    tinymce.PluginManager.add( 'krownShortcodes', function( editor, url ) {

    	editor.addCommand("krownPopup", function ( a, params ) {

			var popup = params.identifier;
		
			// load thickbox
			tb_show("Krown Shortcodes", url + "/popup.php?popup=" + popup + "&width=700");

			jQuery('#custom-tb').remove();

			jQuery('head').append('<style id="custom-tb">#krown-popup { height: ' + (document.documentElement.clientHeight-120) + 'px !important; } #TB_ajaxContent { background: #fff; }</style>');

		});

		// Create values array

		var valuesArr = Array();

		for(var i = 0; i < krownShortcodes.shortcodesList.length; i++) {

			valuesArr[i] = {
				text: krownShortcodes.shortcodesList[i][0],
				id: krownShortcodes.shortcodesList[i][1],
				onClick: function(){
					tb_show("Krown Shortcodes", url + "/popup.php?popup=" + this._id + "&width=700");
					jQuery('#custom-tb').remove();
					jQuery('head').append('<style id="custom-tb">#krown-popup { height: ' + (document.documentElement.clientHeight-120) + 'px !important; } #TB_ajaxContent { background: #fff; }</style>');
				}
			};

		}

        editor.addButton( 'krown_button', {
            type: 'listbox',
            text: 'Insert Shortcode',
            icon: 'ks',
            onselect: function(e) {},
            values: valuesArr
        });
 
    });
 
})();