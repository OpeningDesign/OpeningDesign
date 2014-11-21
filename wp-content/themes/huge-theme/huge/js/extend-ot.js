(function($){

    $(document).ready(function(){

        $('a.delete-gallery').click(function(e){
            e.preventDefault();
            $("#pp_gallery_slider").val('');
            $('#option-tree-gallery-list').html(' ')
        })

    wp.media.neviagallery = {

        frame: function() {
            if ( this._frame )
                return this._frame;
            var selection = this.select();
            this._frame = wp.media({
                id:         'my-frame',
                frame:      'post',
                state:      'gallery-edit',
                title:      wp.media.view.l10n.editGalleryTitle,
                editing:    true,
                multiple:   true,
                selection:  selection
            });

            this._frame.on( 'update',
               function() {
                var controller = wp.media.neviagallery._frame.states.get('gallery-edit');
                var library = controller.get('library');
                            // Need to get all the attachment ids for gallery
                            var ids = library.pluck('id');
                            $('#pp_gallery_slider').val(ids);
                            //update gallery list

                            $('#option-tree-gallery-list').slideUp();
                            $.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                dataType:'html',
                                data: {
                                    action: 'attachments_update',
                                    ids: ids

                                },
                                success:function(res) {
                                    $('#option-tree-gallery-list').html(res).slideDown();
                                    $('#option-tree-gallery-list').next('p').hide();
                                }
                            });
                        });
            return this._frame;


        },
        // Gets initial gallery-edit images. Function modified from wp.media.gallery.edit
        // in wp-includes/js/media-editor.js.source.html
        select: function() {
            var shortcode = wp.shortcode.next( 'gallery', wp.media.view.settings.neviagallery.shortcode ),
            defaultPostId = wp.media.gallery.defaults.id,
            attachments, selection;

            // Bail if we didn't match the shortcode or all of the content.
            if ( ! shortcode )
                return;

            // Ignore the rest of the match object.
            shortcode = shortcode.shortcode;

            if ( _.isUndefined( shortcode.get('id') ) && ! _.isUndefined( defaultPostId ) )
                shortcode.set( 'id', defaultPostId );

            attachments = wp.media.gallery.attachments( shortcode );
            selection = new wp.media.model.Selection( attachments.models, {
                props:    attachments.props.toJSON(),
                multiple: true
            });

            selection.gallery = attachments.gallery;

            // Fetch the query's attachments, and then break ties from the
            // query to allow for sorting.
            selection.more().done( function() {
                // Break ties with the query.
                selection.props.set({ query: false });
                selection.unmirror();
                selection.props.unset('orderby');
            });

            return selection;
        },

        init: function() {
            $('.addgallery').live('click', function( event ){
                event.preventDefault();
                wp.media.neviagallery.frame().open();
            });
        }
    };

    wp.media.neviagallery.init();


    });
})(this.jQuery);