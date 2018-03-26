(function($) {
	Dropzone.autoDiscover = false;
	$("#dropzone-images").dropzone({
		addRemoveLinks: true,
		init: function(){
			this.on("success", function(file, response){
				console.log(response);

				if (response) {
					response = JSON.parse(response);
					$(file.previewTemplate).append(
						"<a class='dz-remove' target='_blank' href='"+response.image.url+"'>URL</a>"+
						'<a class="dz-crop" href="'+ response.image.url +'" data-toggle="modal" data-target="#modal-crop">Crop image</a>'
					);
					if ($('#image').length > 0) {
						$("#image").val(response.image.url);
						console.log(response.image.url);
					}
				}

			});
		}
	});
})(jQuery);