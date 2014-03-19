<?php namespace PhotoUpload\Controllers\Web;

use PhotoUpload\Repositories\Image\ImageRepositoryInterface;
use PhotoUpload\Services\Image\Upload\ImageUploadInterface;

/**
 * ImageController 
 * 
 * @author Branislav Vladisavljev 
 * TODO make abstraction for filesystem uploads and deletes, consider managing assets on CDN
 */
class ImageController extends BaseController {

  protected $imageRepo;
  protected $imageUpload;

  function __construct(ImageRepositoryInterface $imageRepo, ImageUploadInterface $imageUpload)
  {
    $this->imageRepo = $imageRepo;
    $this->imageUpload = $imageUpload;
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
    return View::make('images.index')->with(compact('images'));
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
        //If the validation fails, we redirect the user to the index page, with the error messages 
        if ($this->validator->with(Input::all())->fails()) 
        {
            return Redirect::to('home')
                    ->withInput()
                    ->withErrors($validation);
        } else {    
            //If the validation passes, we upload the image to the database and process it
            $image = Input::file('image');
            $this->imageUpload->handle($image);            
            
            //If the file is now uploaded, we show an error message to the user, else we add a new column to the database and show the success message
            if ($this->imageUpload->succeeds()) {
                $imageRepo->model->create([
                    'img_init_big' => $this->imageUpload->jsonBody['path'],
                    'img_init_min' => $this->imageUpload->jsonBody['pathThumb']
                ]);
                //Now we redirect to the image's permalink
                return Redirect::to('image.show', array($imageRepo->model->id))->with('success', 'Your image is uploaded successfully!');
            } else {
                //image cannot be uploaded
                return Redirect::to('home')->withInput()->with('error', 'Sorry, the image could not be uploaded, please try again later');
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
          return Redirect::to('home')->with('error', 'Image not found');
      }

      return View::make('images.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
   */
  public function edit($id)
	{
    $images = $this->repo->getById($id);
      
    return View::make('images.edit', compact('images'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
    if ($this->validator->with(Input::all())->passes())
    {
        $this->repo->update($id, Input::all());

        return Redirect::route('image.index')->withMessage('Image updated successfully');
    }

    return Redirect::route('image.edit', $id)
                ->withInput()                   
                ->withMessage('There was a problem updating the image')
                ->withErrors($this->validator->errors());
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
    $image = $this->imageRepo->getById($id);

    //If there's an image, we will continue to the deleting process
    if ($image) {
        //First, let's delete the images from FTP
        File::delete(Config::get('image.upload_path') . '/' . $image->image);
        File::delete(Config::get('image.thumb_path') . '/' . $image->image);

        //Now let's delete the value from database
        $image->delete();

        //Let's return to the main page with a success message
        return Redirect::to('home')->with('success', 'Image deleted successfully');

    } else {
        //Image not found, so we will redirect to the index page with an error message flash data.
        return Redirect::to('home')->with('error', 'No image with given ID found');
    }
	}
}
