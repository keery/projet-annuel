/**
* @author Guillaume ESNAULT
*/
(function($)
{
	$.fn.GEUploader = function(option)
	{
		option = $.extend({
			route : 'ajax_img',
			dossier_upload : '',
			maxWidth : 1920,
			maxHeight : 1080,
			nbFichiersMax : 50
		}, option);

		//Classe
		function GEUploader(elem, p)
		{

			var entity_name = option.entity.split(":"),
				nbExist = null,
				prev_msg;


			if (entity_name[1] != null) 
			{
				entity_name = entity_name[1].toLowerCase();
			}

			var images_div = "#"+entity_name+"_images";


			elem
			.on('dragenter', function(event){

				event.preventDefault();
				prev_msg = $(this).attr("data-message");
				$(this).addClass('dropOver').attr("data-message", "Lachez votre fichier");

			}).on('dragleave', function(){

				$(this).removeClass('dropOver').attr("data-message", prev_msg);

			}).on('dragover', function(event){

				event.preventDefault();

			}).on('drop, change', function(event){

				event.preventDefault();
				event.stopPropagation();


				if (event.type == "change") 
				{
					var dropzone = $(this).parent().next('.dropzone'),
						filesList = this.files;
				}
				else
				{
					var dropzone = $(this),
					filesList = event.originalEvent.dataTransfer.files;
				}

				if (filesList.length > option.nbFichiersMax) 
				{					
					alert("La limite est de "+ nbFichiersMax+" fichiers maximum");
					
				}
				else
				{
					if (filesList.length > 0) 
					{
						for (var i = 0; i < option.nbFichiersMax; i++) 
						{
							if (MIMEis(filesList[i], ['img']))
							{
								creerImage(filesList[i], dropzone);
							}
							else
							{
								console.log('Le fichier '+i+' n\'est pas du bon format');
							}
						}
					}
					else
					{
						console.log("Un problème est survenu")
					}					
				}

			});

			function creerMiniature (img, dropzone)
			{
				if (dropzone.attr('data-message') != '')
				{
					dropzone.attr('data-message', '');
				}
			}


			function uploadImg(route, data_base64)
			{
				var dataForm = new FormData();
				dataForm.append("data_base64", data_base64);
				dataForm.append("id_entity", $("input[name='id_entity']").val());
				dataForm.append("entity", option.entity);
				dataForm.append("dossier_upload", option.dossier_upload);

				if (elem.hasClass('input-file')) 
				{
					var dropzone = elem.parent().next('.dropzone');
				}
				else
				{
					var dropzone = elem;
				}

				var loader;

				$.ajax({
					url: Routing.generate(route),
				    type: "POST",
				    data: dataForm,
				    contentType: false,
		     		processData: false,
				    dataType: 'json',
				    beforeSend: function() 
				    {
				    	var miniature = $("<div class='miniature' style='background-image: url("+data_base64+")'></div>");
				    	loader = $("<span class='loader'></span>");
				    	dropzone.append(miniature);
				    	miniature.append(loader);
				    },
				    success: function (response) 
				    {
			    		loader.remove();
						var list = dropzone.next(".img-list"),
							val = $("#id_files").val();
						if (option.nbFichiersMax > 1) 
						{
							// var proto = '<li><div class="col-2 photo"></div><div class="col-2 img-input"><input type="file" id="'+entity_name+'_images___name___image" name="'+entity_name+'[images][__name__][image]" /><div class="input-form full"><label for="'+entity_name+'_images___name___alt">Alt</label><input type="text" id="'+entity_name+'_images___name___alt" name="'+entity_name+'[images][__name__][alt]" class="input" /></div><div class="input-form full"><label for="'+entity_name+'_images___name___title">Title</label>	<input type="text" id="'+entity_name+'_images___name___title" name="'+entity_name+'[images][__name__][title]"  class="input"/></div></div></li>';
							if ($(images_div).find("li").length == 0) 
							{
								var id = addImg($(images_div), 0, entity_name, data_base64);
							}
							else
							{
								var id_last_child = ($(images_div+" li:last-child input[type='text']").attr("id"));
								var split = id_last_child.split(/_([\d]+)_/)[1];

								if ($.isNumeric(split) && split != undefined) 
								{
									addImg($(images_div), parseInt(split)+1, entity_name, data_base64);
								}				
							}

							if (response.entity == false) 
							{
								if (val == "") 
								{
									$("#id_files").val(response.id_file);					
								}
								else
								{
									val += ", "+response.id_file;
									$("#id_files").val(val);
								}		
							}

						}
						else
						{
							var proto = '<li><div class="col-2 photo"></div><div class="panel-action"><button class="delete button btn-icone dial" type="button" title="Supprimer l\'image" data-id="'+response.id_file+'"></button></div><div class="col-2 img-input"><div class="input-form full"><label for="'+entity_name+'_image_alt">Alt</label><input type="text" id="'+entity_name+'_image_alt" name="'+entity_name+'[image][alt]" class="input"></div><div class="input-form full"><label for="'+entity_name+'_image_title">Title</label><input type="text" id="'+entity_name+'_image_title" name="'+entity_name+'[image][title]" class="input"></div></div></li>';
							
							list.find("li:last-child").find(".photo").append(img);


							list.children("li").remove();
							list.append(proto);
							list.find(".photo").append(img);

							$("#id_files").val(response.id_file);	
						}
				    },
				    error: function(erreur, etat) 
				    {
				    	console.log("ERREUR");
				    }

				});
			}

			function addImg(container, index, entity_name, imgSRC, value="") 
		    {

		    	var template = container.attr('data-prototype')
		    	  .replace(/_entity_name_/g, entity_name)
		    	  .replace(/__name__/g,        index)
		    	  .replace(/__value__/g,       value)
		    	  .replace(/__img__/g, 		   imgSRC)
		    	;

		    	var $prototype = $(template);

		    	container.find("ul").append($prototype);
		    }

			function creerImage (file, dropzone)
			{
				var reader = new FileReader();

				reader.onload = function(event) 
				{
					img = createImg(reader.result);

			     	img.onload = function(event)
			     	{
						var largeur = this.width,
							hauteur = this.height,
			     			size = imageSize(largeur, hauteur, option.maxWidth, option.maxHeight);

				     	var canvas = document.createElement("canvas");
							canvas.width = size.width;
							canvas.height = size.height;
						
						var ctx = canvas.getContext("2d");
							ctx.drawImage(this, 0, 0, size.width, size.height);

						var data = canvas.toDataURL(file.type);

				     	creerMiniature(img, dropzone);

				     	uploadImg(option.route, data);
			     	}
				}

				reader.onerror = function() {
			  		alert("Nous avons rencontré un problème lié à votre fichier, il n'a pas pu être chargé");
			  	}

				reader.readAsDataURL(file);
			}
			
			function imageSize(width, height, maxWidth, maxHeight)
			{
				var newWidth = width, 
				newHeight = height;
				
				if(width > height)
				{
					if(width > maxWidth)
					{
						newHeight *= maxWidth / width;
						newWidth = maxWidth;
					}
					if(newHeight > maxHeight)
					{
						newWidth *= maxHeight / newHeight;
						newHeight = maxHeight;
					}
				}
				else
				{
					if(height > maxHeight)
					{
						newWidth *= maxHeight / height;
						newHeight = maxHeight;
					}
					if(newWidth > maxWidth)
					{
						newHeight *= maxWidth / newWidth;
						newWidth = maxWidth;
					}
				}
				
				return { width: newWidth, height: newHeight };
			}
				
		}

		function createImg(src)
		{
			var img = new Image();
			img.src = src;
			return img
		}
		
		return this.each(
			function()
			{
				var elem = $(this), 
				GEUploaderAPI = elem.data("GEUploaderAPI");

				if(GEUploaderAPI);
				else
				{
					GEUploaderAPI = new GEUploader(elem, option);
					elem.data("GEUploaderAPI", GEUploaderAPI);
				}
			}
		);
	};
	
})(jQuery);