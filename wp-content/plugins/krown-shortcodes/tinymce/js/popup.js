
// start the popup specefic scripts
// safe to use $
jQuery(document).ready(function($) {
    var krowns = {
    	loadVals: function()
    	{
    		var shortcode = $('#_krown_shortcode').text(),
    			uShortcode = shortcode;
    		
    		// fill in the gaps eg {{param}}
    		$('.krown-input').each(function() {
    			var input = $(this),
    				id = input.attr('id'),
    				id = id.replace('krown_', ''),		// gets rid of the krown_ prefix
    				re = new RegExp("{{"+id+"}}","g");
    				
    			uShortcode = uShortcode.replace(re, input.val());
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_krown_ushortcode').remove();
    		$('#krown-sc-form-table').prepend('<div id="_krown_ushortcode" class="hidden">' + uShortcode + '</div>');
    	},
    	cLoadVals: function()
    	{
    		var shortcode = $('#_krown_cshortcode').text(),
    			pShortcode = '';
    			shortcodes = '';
    		
    		// fill in the gaps eg {{param}}
    		$('.child-clone-row').each(function() {
    			var row = $(this),
    				rShortcode = shortcode;
    			
    			$('.krown-cinput', this).each(function() {
    				var input = $(this),
    					id = input.attr('id'),
    					id = id.replace('krown_', '')		// gets rid of the krown_ prefix
    					re = new RegExp("{{"+id+"}}","g");
    					
    				rShortcode = rShortcode.replace(re, input.val());
    			});
    	
    			shortcodes = shortcodes + rShortcode + "\n";
    		});
    		
    		// adds the filled-in shortcode as hidden input
    		$('#_krown_cshortcodes').remove();
    		$('.child-clone-rows').prepend('<div id="_krown_cshortcodes" class="hidden">' + shortcodes + '</div>');
    		
    		// add to parent shortcode
    		this.loadVals();
    		pShortcode = $('#_krown_ushortcode').text().replace('{{child_shortcode}}', shortcodes);
    		
    		// add updated parent shortcode
    		$('#_krown_ushortcode').remove();
    		$('#krown-sc-form-table').prepend('<div id="_krown_ushortcode" class="hidden">' + pShortcode + '</div>');
    	},
    	children: function()
    	{
    		// assign the cloning plugin
    		$('.child-clone-rows').appendo({
    			subSelect: '> div.child-clone-row:last-child',
    			allowDelete: false,
    			focusFirst: false
    		});
    		
    		// remove button
    		$('.child-clone-row-remove').live('click', function() {
    			var	btn = $(this),
    				row = btn.parent();
    			
    			if( $('.child-clone-row').size() > 1 )
    			{
    				row.remove();
    			}
    			else
    			{
    				alert('You need a minimum of one row');
    			}
    			
    			return false;
    		});
    		
    		// assign jUI sortable
    		$( ".child-clone-rows" ).sortable({
				placeholder: "sortable-placeholder",
				items: '.child-clone-row'
				
			});
    	},
    	resizeTB: function()
    	{
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				krownPopup = $('#krown-popup');

            tbWindow.css({
                height: krownPopup.outerHeight() + 50,
                width: krownPopup.outerWidth(),
                marginLeft: -(krownPopup.outerWidth()/2)
            });

			ajaxCont.css({
				paddingTop: 0,
				paddingLeft: 0,
				paddingRight: 0,
				height: (tbWindow.outerHeight()-47),
				overflow: 'auto', // IMPORTANT
				width: krownPopup.outerWidth()
			});
			
			$('#krown-popup').addClass('no_preview');
    	},
    	load: function()
    	{
    		var	krowns = this,
    			popup = $('#krown-popup'),
    			form = $('#krown-sc-form', popup),
    			shortcode = $('#_krown_shortcode', form).text(),
    			popupType = $('#_krown_popup', form).text(),
    			uShortcode = '';
    		
    		// resize TB
    		krowns.resizeTB();
    		$(window).resize(function() { krowns.resizeTB() });
    		
    		// initialise
    		krowns.loadVals();
    		krowns.children();
    		krowns.cLoadVals();
    		
    		// update on children value change
    		$('.krown-cinput', form).live('change', function() {
    			krowns.cLoadVals();
    		});
    		
    		// update on value change
    		$('.krown-input', form).change(function() {
    			krowns.loadVals();
    		});
    		
    		// when insert is clicked
    		$('.krown-insert', form).click(function() {    		 
    			if(window.tinyMCE)
				{ 
                    window.tinyMCE.execCommand('mceInsertContent', false, $('#_krown_ushortcode', form).html());
					tb_remove();
				}
    		});
    	}
	}
    
    // run
    $('#krown-popup').livequery( function() { krowns.load(); } );
});