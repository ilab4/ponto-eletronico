$(document).ready(function() {
	
	// enable fileuploader plugin
	$('input[name="files"]').fileuploader({
        extensions: null,
		changeInput: ' ',
		theme: 'thumbnails',
                enableApi: true,
//                upload: true,
		addMore: true,
		thumbnails: {
			box: '<div class="fileuploader-items">' +
                      '<ul class="fileuploader-items-list">' +
					      '<li class="fileuploader-thumbnails-input"><div class="fileuploader-thumbnails-input-inner"><i class="fa fa-upload"></i><i><p style="font-size: 16px;"><br><br><br><br></p></i></div></li>' +
                      '</ul>' +
                  '</div>',
			item: '<li class="fileuploader-item file-has-popup">' +
				       '<div class="fileuploader-item-inner">' +
                           '<div class="type-holder">${extension}</div>' +
                           '<div class="actions-holder">' +
                                                            '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
						   	   '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                           '</div>' +
                           '<div class="thumbnail-holder">' +
                               '${image}' +
                               '<span class="fileuploader-action-popup"></span>' +
                           '</div>' +
                           '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                       	   '<div class="progress-holder">${progressBar}</div>' +
                       '</div>' +
                  '</li>',
			item2: '<li class="fileuploader-item file-has-popup">' +
				       '<div class="fileuploader-item-inner">' +
                           '<div class="type-holder">${extension}</div>' +
                           '<div class="actions-holder">' +
						   	   '<a href="${file}" class="fileuploader-action fileuploader-action-download" title="${captions.download}" download><i></i></a>' +
						   	   '<a class="fileuploader-action fileuploader-action-sort" title="${captions.sort}"><i></i></a>' +
						   	   '<a class="fileuploader-action fileuploader-action-remove" title="${captions.remove}"><i></i></a>' +
                           '</div>' +
                           '<div class="thumbnail-holder">' +
                               '${image}' +
                               '<span class="fileuploader-action-popup"></span>' +
                           '</div>' +
                           '<div class="content-holder"><h5>${name}</h5><span>${size2}</span></div>' +
                       	   '<div class="progress-holder">${progressBar}</div>' +
                       '</div>' +
                   '</li>',
           removeConfirmation: false,
			startImageRenderer: true,
            canvasImage: false,
            videoThumbnail: true,
			_selectors: {
				list: '.fileuploader-items-list',
				item: '.fileuploader-item',
				start: '.fileuploader-action-start',
				retry: '.fileuploader-action-retry',
				remove: '.fileuploader-action-remove'
			},
			onItemShow: function(item, listEl, parentEl, newInputEl, inputEl) {
				var plusInput = listEl.find('.fileuploader-thumbnails-input'),
                    api = $.fileuploader.getInstance(inputEl.get(0));
				
                plusInput.insertAfter(item.html)[api.getOptions().limit && api.getChoosedFiles().length >= api.getOptions().limit ? 'hide' : 'show']();
				
				if(item.format == 'image') {
					item.html.find('.fileuploader-item-icon').hide();
				}
			}
		},
        dragDrop: {
			container: '.fileuploader-thumbnails-input'
                        
		},
		afterRender: function(listEl, parentEl, newInputEl, inputEl) {
			var plusInput = listEl.find('.fileuploader-thumbnails-input'),
				api = $.fileuploader.getInstance(inputEl);
		
			plusInput.on('click', function() {
				api.open();
			});
		},
//		upload: {
//			url: '../ajaxUpload',
//            data: null,
//            type: 'POST',
//            enctype: 'multipart/form-data',
//            start: true,
//            synchron: true,
//            beforeSend: null,
//            onSuccess: function(data, item) {
//				item.html.find('.fileuploader-action-remove').addClass('fileuploader-action-success');
//                
//				setTimeout(function() {
//					item.html.find('.progress-holder').hide();
//					item.renderThumbnail();
//                    
//                    item.html.find('.fileuploader-action-popup, .fileuploader-item-image').show();
//                    item.html.find('.fileuploader-action-remove').before('<a class="fileuploader-action fileuploader-action-sort" title="Sort"><i></i></a>');
//				}, 400);
//            },
//            onError: function(item) {
//				item.html.find('.progress-holder, .fileuploader-action-popup, .fileuploader-item-image').hide();
//            },
//            onProgress: function(data, item) {
//                var progressBar = item.html.find('.progress-holder');
//				
//                if(progressBar.length > 0) {
//                    progressBar.show();
//                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
//                }
//                
//                item.html.find('.fileuploader-action-popup, .fileuploader-item-image').hide();
//            }
//        },
        sorter: {
			selectorExclude: null,
			placeholder: null,
			scrollContainer: window,
			onSort: function(list, listEl, parentEl, newInputEl, inputEl) {
                var api = $.fileuploader.getInstance(inputEl.get(0)),
                    fileList = api.getFileList(),
                    _list = [];
                
                $.each(fileList, function(i, item) {
                    _list.push({
                        name: item.name,
                        index: item.index
                    });
                });
                
                $.post('../ajaxUploadSort', {
                    _list: JSON.stringify(_list)
                });
			}
		},
        onRemove: function(item) {
			$.post('php/ajax_remove_file.php', {
				file: item.name
			});
		},
                
        captions: {
                    button: function(options) { return 'Buscar ' + (options.limit == 1 ? 'foto' : 'fotos'); },
                    feedback: function(options) { return 'Selecionar ' + (options.limit == 1 ? 'foto' : 'fotos') + ' to upload'; },
                    feedback2: function(options) { return options.length + ' ' + (options.length > 1 ? ' fotos were' : ' file was') + ' chosen'; },
                    confirm: 'Confirmar',
                    cancel: 'Cancelar',
                    name: 'Nome',
                    type: 'Tipo',
                    size: 'Taanho',
                    dimensions: 'Dimensões',
                    duration: 'Duration',
                    crop: 'Cortar',
                    rotate: 'Rotacionar',
                    sort: 'Ordenar',
                    download: 'Download',
                    remove: 'Remover',
                    drop: 'Arraste aqui seus arquivos para upload',
                    paste: '<div class="fileuploader-pending-loader"></div> Pasting a file, click here to cancel.',
                    removeConfirmation: 'Tem certeza que deseja excluir esse arquivo?',
                    errors: {
                        filesLimit: 'São permitidos somentes ${limit} fotos.',
                        filesType: 'Somente arquivos tipo ${extensions} são permitidos.',
                        fileSize: '${name} é muito grande! Favor selecionar uma foto com até ${fileMaxSize}MB.',
                        filesSizeAll: 'Arquivos selecionados excederam o tamanho máximo permitido de ${maxSize} MB.',
                        fileName: 'File with the name ${name} is already selected.',
                        folderUpload: 'You are not allowed to upload folders.'
                    }
                }        
	});
	
});