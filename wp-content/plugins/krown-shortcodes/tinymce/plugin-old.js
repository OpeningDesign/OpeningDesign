(function ()
{
	// create krownShortcodes plugin
	tinymce.create("tinymce.plugins.krownShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("krownPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("Krown Shortcodes", url + "/popup.php?popup=" + popup + "&width=700");

				jQuery('#custom-tb').remove();

				jQuery('head').append('<style id="custom-tb">#krown-popup { height: ' + (document.documentElement.clientHeight-120) + 'px !important; } #TB_ajaxContent { background: #fff; }</style>');

			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "krown_button" )
			{	
				var a = this;

				var btn = e.createSplitButton('krown_button', {
                    title: "Krown Shortcodes",
					image: krownShortcodes.pluginFolder +"/tinymce/images/icon.png",
					icons: false
                });

                btn.onRenderMenu.add(function (c, b)
				{					

					for(var i = 0; i < krownShortcodes.shortcodesList.length; i++){
						a.addWithPopup( b, krownShortcodes.shortcodesList[i][0], krownShortcodes.shortcodesList[i][1] );
					}

				});
                
                return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("krownPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'Krown Shortcodes',
				author: 'Ruben Bristian',
				authorurl: 'http://rubenbristian.com',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.0"
			}
		}
	});
	
	// add krownShortcodes plugin
	tinymce.PluginManager.add("krownShortcodes", tinymce.plugins.krownShortcodes);

})();