jQuery(document).ready(function($) {
    "use strict";

    /**
     * ============================================
     * TinyMCE Custom Control
     * ============================================
     */
    $('.customize-control-tinymce-editor').each(function() {
        // Get the toolbar strings that were passed from the PHP Class
        var tinyMCEToolbar1String = _wpCustomizeSettings.controls[$(this).attr('id')].tinymcetoolbar1;
        var tinyMCEToolbar2String = _wpCustomizeSettings.controls[$(this).attr('id')].tinymcetoolbar2;
        var tinyMCEMediaButtons = _wpCustomizeSettings.controls[$(this).attr('id')].tinymcemediabuttons;

        wp.editor.initialize($(this).attr('id'), {
            tinymce: {
                wpautop: true,
                toolbar1: tinyMCEToolbar1String,
                toolbar2: tinyMCEToolbar2String
            },
            quicktags: true,
            mediaButtons: tinyMCEMediaButtons
        });
    });
    $(document).on('tinymce-editor-init', function(event, editor) {
        editor.on('change', function(e) {
            tinyMCE.triggerSave();
            $('#' + editor.id).trigger('change');
        });
    });
});

(function(api) {

    api.sectionConstructor['parablog-upsell'] = api.Section.extend({

        // Remove events for this section.
        attachEvents: function() {},

        // Ensure this section is active. Normally, sections without contents aren't visible.
        isContextuallyActive: function() {
            return true;
        }
    });

    const parablog_section_lists = ['banner','categories'];
    parablog_section_lists.forEach(parablog_homepage_scroll);

    function parablog_homepage_scroll(item, index) {
        // Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
        item = item.replace(/-/g, '_');
        wp.customize.section('parablog_' + item + '_section', function(section) {
            section.expanded.bind(function(isExpanding) {
                // Value of isExpanding will = true if you're entering the section, false if you're leaving it.
                wp.customize.previewer.send(item, { expanded: isExpanding });
            });
        });
    }
})(wp.customize);