@extends('layouts.main')

@section('title', 'Trick')

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/jquery.Jcrop.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('css/highlight/laratricks.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('js/selectize/css/selectize.bootstrap3.css') }}">
	<style type="text/css">
    #PresetFilters a {
      border-radius: 3px;
      -webkit-transition: background-color .3s ease-out;
      -moz-transition: background-color .3s ease-out;
      transition: background-color .3s ease-out;
      background-color: #368ad2;
      display: block;
      float: left;
      text-align: center;
      padding: 8px 10px;
      color: #f8f8f2;
      margin: 5px;
      border: none;
      font-size: 13px;
      width: 120px;
      cursor: pointer;
    }

    #PresetFilters a.Active {
      background-color: #e69751;
    }
  
    #editor-content {
      position: relative;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      height: 300px;
      -webkit-border-radius: 4px;
      -moz-border-radius: 4px;
      border-radius: 4px;
      border: 1px solid #cccccc;
    }
    </style>
@stop

@section('scripts')
	<script type="text/javascript" src="{{url('js/selectize/js/standalone/selectize.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('js/trick-new-edit.min.js') }}"></script>
@if(Session::get('errors') == null)
  <script src="{{ asset('js/vendor/uploader/FileAPI.min.js') }}"></script>
  <script src="{{ asset('js/vendor/uploader/caman.full.min.js') }}"></script>
<script type="text/javascript">

    // (function (){
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
           url: '{{ route("images.render") }}',
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
    // })();
    });
  
</script>
@endif
@stop

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-lg-push-2 col-md-8 col-md-push-2 col-sm-12 col-xs-12">
				<div class="content-box" >
					<h1 class="page-title">
						Creating a new render 
					</h1>
					@if(Session::get('errors'))
					    <div class="alert alert-danger alert-dismissable">
					        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					         <h5>There were errors while creating this render:</h5>
					         @foreach($errors->all('<li>:message</li>') as $message)
					            {{$message}}
					         @endforeach
					    </div>
					@endif
					{{ Form::open(array('class'=>'form-vertical','id'=>'save-trick-form','role'=>'form'))}}
					    <div class="form-group">
					    	<label for="title">Title</label>
					    	{{Form::text('title', null, array('class'=>'form-control','placeholder'=>'Name this trick'));}}
					    </div>
					    <div class="form-group">
					    	<label for="description">Description</label>
					    	{{Form::textarea('description',null, array('class'=>'form-control','placeholder'=>'Give detailed description of the trick','rows'=>'3'));}}
					    </div>
            <div class="form-group">
      <input type="hidden" id="render-hidden" name="render" value="{{Session::get('render')}}">
  </div>

					    <div class="form-group">
					    	<p>{{ Form::select('tags[]', $tagList, null, array('multiple','id'=>'tags','placeholder'=>'Tag  this trick','class' => 'form-control')); }}</p>
              </div>
              {{HTML::image(Config::get('image.upload_folder_tmp') . '/' . Session::get('render'), 'render', ['id'=>'renderimg'])}}
					    <div class="form-group">
					        <div class="text-right">
					          <button type="submit"  id="save-section" class="btn btn-primary ladda-button" data-style="expand-right">
					            Save Trick
					          </button>
					        </div>
					    </div>
            </div>

					{{Form::close()}}
    <div id="output" style="display: none; padding: 10px 20px 40px;">
      <div id="result" style="text-align: center; margin: 0 auto;">
      <div class="loader"></div>
    </div>

    <div id="PresetFilters">
      <a data-preset="vintage" class="Active">Vintage</a>
      <a data-preset="lomo">Lomo</a>
      <a data-preset="clarity">Clarity</a>
      <a data-preset="sinCity">Sin City</a>
      <a data-preset="sunrise">Sunrise</a>
      <a data-preset="crossProcess">Cross Process</a>
      <a data-preset="orangePeel">Orange Peel</a>
      <a data-preset="love">Love</a>
      <a data-preset="grungy">Grungy</a>
      <a data-preset="jarques">Jarques</a>
      <a data-preset="pinhole">Pinhole</a>
      <a data-preset="oldBoot">Old Boot</a>
      <a data-preset="glowingSun">Glowing Sun</a>
      <a data-preset="hazyDays">Hazy Days</a>
      <a data-preset="herMajesty">Her Majesty</a>
      <a data-preset="nostalgia">Nostalgia</a>
      <a data-preset="hemingway">Hemingway</a>
      <a data-preset="concentrate">Concentrate</a>
    </div>
				</div>

<div class="form-group" style="text-align: center; padding: 50px; clear: both; font-size: 20px;">
                  <div id="uploadimage" style="display:none; margin-bottom:20px"class="btn btn-sm btn-primary js-fileapi-wrapper">
                     <div class="js-browse">
                        <span class="btn">Upload</span>
                     </div>
                     <div class="js-upload" style="display: none;">
                        <div class="progress progress-success"><div class="js-progress bar"></div></div>
                        <span class="btn-txt">Uploading</span>
                     </div>
                  </div>
    <div id="choose" style="display:none" class="btn btn-sm btn-primary js-fileapi-wrapper">
      <label for="browse" class="btn">Select Photo</label>
      <input id="browse" type="file" accept="image/*" style="font-size: 20px; display: none;">
    </div>

    <div id="photoBooth" style="visibility: hidden; position: absolute; overflow: hidden; height: 0">
      <div id="cam" style="border: 2px solid #80BD95; padding: 2px; width: 640px; height: 480px; margin: 0 auto;"></div>
      <div id="shot" class="btn" style="border-radius: 100%; width: 80px; height: 80px; padding: 0; margin: 30px;"></div>
    </div>
</div>
			</div>
		</div>
	</div>
@stop
