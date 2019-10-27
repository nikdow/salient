(function() {
	tinymce.create('tinymce.plugins.nectartiny', {
		init : function(ed, url) {
		 ed.addCommand('shortcodeGenerator', function() {
		 	
		 		tb_show("Nectar Shortcodes", url + '/shortcode_generator/shortcode-generator.php?&width=630&height=600');

				
		 });
			//Add button
			ed.addButton('scgenerator', {	title : 'Nectar Shortcodes', cmd : 'shortcodeGenerator', image : url + '/shortcode_generator/icons/shortcode-generator.png' });
        },
        createControl : function(n, cm) {
			  return null;
        },
		  getInfo : function() {
			return {
				longname : 'nectar TinyMCE',
				author : 'ThemeNectar',
				authorurl : 'http://themenectar.com',
				infourl : 'http://themenectar.com',
				version : tinymce.majorVersion + "." + tinymce.minorVersion
			};
		}
    });
    tinymce.PluginManager.add('nectar_buttons', tinymce.plugins.nectartiny);
})();