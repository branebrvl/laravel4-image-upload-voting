  $(function() {
    var
        file
      ,  renderedFile
      , filter = 'vintage' // default filter
      , processing = false
    ;
    
    function _choose(state){
      choose.style.display = state ? '' : 'none';
      photoBooth.style.visibility = !state ? '' : 'hidden';
      photoBooth.style.height = !state ? '' : '20px';
    };

    $('.content-box').css('display', 'none');
    $('#choose').css('display', 'block');

    // Open dialog
    FileAPI.event.on(browse, 'change', function (evt){
      file = FileAPI.getFiles(evt)[0];
      $('.content-box').css('display', 'none');
      if( file ){
        _applyFilter(true);
      }
    });


    // Set filter
    FileAPI.event.on(PresetFilters, 'click', function (evt){
      var el = evt.target;

      if( !processing && el.tagName == 'A' ){
        filter = el.dataset.preset;
        processing = { el: el, html: el.innerHTML };

        el.parentNode.querySelector('.Active').classList.remove('Active');
        el.innerHTML = 'Rendering&hellip;';
        el.className = 'Active';

        _applyFilter();
      }
    });

    FileAPI.event.on(uploadimage, 'click', function (evt) {
      FileAPI.upload({
         url: "{{ route('images.render') }}",
         accept: 'image/*',
         data: { _token: "{{ csrf_token() }}" },
         imageSize: { minWidth: 100, minHeight: 100 },
         elements: {
            active: { show: '.js-upload', hide: '.js-browse' },
            progress: '.js-progress'
         },
         files: { filedata: renderedFile},
        complete: function (err, xhr){
          try {
            $('#PresetFilters').css('display', 'none');
            $('.content-box').css('display', '');
            $('#uploadimage').css('display', 'none');
            $('#output').css('display', 'none');
            $('#choose').css('display', 'none');
            // console.log(evt, xhr);
            // var result = FileAPI.parseJSON(xhr.xhr.responseText);
            var result = JSON.parse(xhr.response);
            $('#renderimg').attr('src', $('#renderimg').attr('src') + '/' + result.images.filename);
            console.log(result.images.filename);
            $('#render-hidden').attr('value',result.images.filename);
          } catch (er) {
            FileAPI.log('PARSE ERROR:', er.message);
          }
        }
      });
      
    });

    function _applyFilter(loading){
      if( loading ){
        result.innerHTML = '<div class="loader"></div>';
      }
      output.style.display = '';
      uploadimage.style.display = 'block';
      renderedFile = FileAPI.Image(file)
        .resize(500, 500, 'max')
        .filter(filter)

      renderedFile.get(function (err, img){
          result.innerHTML = '';
          result.appendChild(img);
          if( processing ){
            processing.el.innerHTML = processing.html;
            processing = false;
          }
        })
      ;
    }
  });

