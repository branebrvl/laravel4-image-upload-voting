<?php

use Intervention\Image\Facades\Image as ImageInterv;
// use PhotoUpload\Ropositories\Image\ImageRepositoryInterface;
use PhotoUpload\Repositories\Image\ImageRepositoryInterface;

class ImageController extends BaseController {

  protected $imageRepo;

  function __construct(ImageRepositoryInterface $imageRepo)
  {
    $this->imageRepo = $imageRepo;
  }

	/**
   *
   *
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
  {
    $images = $this->imageRepo->getAll();

    // $images = Image::with('user')->get()->toArray();
    return $images;
    return View::make('images.index')->with(compact($images));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
   * TODO remove from route
	 */
	public function create()
	{
        // return View::make('images.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        //Let's validate the form first with the rules which are set at the model
        $validation = Validator::make(Input::all(), Images::$uploadRules);
        
        //If the validation fails, we redirect the user to the index page, with the error messages 
        if ($validation->fails()) {
            return Redirect::to('/')
                    ->withInput()
                    ->withErrors($validation);
        } else {    
            //If the validation passes, we upload the image to the database and process it
            $image = Input::file('image');
            
            //This is the original uploaded client name of the image
            $filename = $image->getClientOriginalName();
            //Because Syfony API does not provide file name without extension, we will be using raw PHP here
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            
            //We should salt and make an url-friendly version of the file name
            //(In ideal application, you should check the file name to be unique)
            $fullname = Str::slug(Str::random(8) . $filename) . '.' . $image->getClientOriginalExtension();
            
            //We upload the image first to the upload folder, then get make a thumbnail from the uploaded image
            $upload = $image->move(Config::get('image.upload_path'), $fullname);
            
            //Our model that we've created is named Images, this library has an alias named Image, don't mix them two!
            //These parameters are related to the image processing class that we've included, not really related to Laravel
            try
            {
              ImageInterv::make(Config::get('image.upload_path') . '/' . $fullname)
                      ->resize(Config::get('image.thumb_width'), null, true)
                      ->save(Config::get('image.thumb_path') . '/' . $fullname);
            }         
            catch (Exception $e)
            {
              Log::error('[IMAGE SERVICE] Failed to resize image "' . $fullname . '" [' . $e->getMessage() . ']');
            } 
            
            //If the file is now uploaded, we show an error message to the user, else we add a new column to the database and show the success message
            if ($upload) {
                // $insert_id = DB::table('images')->insertGetId(array(
                // )); 
                
                $image =Image::create([
                    'img_init_big' => Config::get('image.upload_path').'/'.$fullname,
                    'img_init_min' => Config::get('image.thumb_path').'/'.$fullname
                ]);
                //Now we redirect to the image's permalink
                return Redirect::to(URL::to('show/' . $image->id))->with('success', 'Your image is uploaded successfully!');
            } else {
                //image cannot be uploaded
                return Redirect::to('/')->withInput()->with('error', 'Sorry, the image could not be uploaded, please try again later');
            }   
        }  
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
      //Let's try to find the image from database first
      // $image = Image::find($id);
      $image = $this->imageRepo->getById($id);
      //If found, we load the view and pass the image info as parameter, else we redirect to main page with error message
      if ($image) {
          return View::make('images.show')->with('image', $image);
      } else {
          return Redirect::to('/')->with('error', 'Image not found');
      }
        // return View::make('images.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */public function edit($id)
	{
        // return View::make('images.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        //Let's first find the image
        // $image = Images::find($id);
        $image = $this->imageRepo->getById($id);

        //If there's an image, we will continue to the deleting process
        if ($image) {
            //First, let's delete the images from FTP
            File::delete(Config::get('image.upload_path') . '/' . $image->image);
            File::delete(Config::get('image.thumb_path') . '/' . $image->image);

            //Now let's delete the value from database
            $image->delete();

            //Let's return to the main page with a success message
            return Redirect::to('/')->with('success', 'Image deleted successfully');

        } else {
            //Image not found, so we will redirect to the index page with an error message flash data.
            return Redirect::to('/')->with('error', 'No image with given ID found');
        }
	}

}
