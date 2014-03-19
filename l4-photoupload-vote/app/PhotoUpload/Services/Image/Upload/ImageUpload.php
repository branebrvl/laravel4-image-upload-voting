<?php namespace PhotoUpload\Services\Image\Upload;

/**
 * ImageUpload 
 * 
 * @uses ImageUploadInterface
 * @author Branislav Vladisavljev 
 */
class ImageUpload implements ImageUploadInterface {

  /**
  * If there are any errors, they will be here
  *
  * @var array
  */
  protected $errors = [];  

  protected $succeeds = false;

  protected $jsonBody;

  /**
   * The extension to use for image files.
   *
   * @var string
   */
  protected $extension = 'jpg';

  /**
  * Filesystem instance.
  *
  * @var \Illuminate\Filesystem\Filesystem      
  */
  protected $filesystem;                

  /**
  * Config instance.
  *
  * @var \Illuminate\Config
  */
  protected $config;  

  /**
  * Create a new ImageUploadService instance.   
  *
  * @param  \Illuminate\Filesystem\Filesystem  $filesystem
  * @param  \Illuminate\Config $config
  * @return void
  */
  public function __construct(Filesystem $filesystem, Config $config) 
  {
      $this->filesystem = $filesystem;           
      $this->config = $config;
  }

  /**
   * errors 
   * 
   * 
   * @return void
   */
  public function errors()
  {
    return $this->errors;
  }

  /**
   * succeeds 
   * 
   * 
   * @return void
   */
  public function succeeds()
  {
    return $this->succeeds;
  }

  /**
   * Get the full path from the given partial path.
   *
   * @param  string  $path
   * @return string
   */
  protected function getFullPath($path)
  {
      return public_path() . '/' . $path;
  }

  /**
   * Make a new unique filename
   *
   * @return string
   */
  protected function makeFilename()
  {
      return sha1(time() . time()) . ".{$this->extension}";
  }

  /**
   * Get the contents of the file located at the given path.
   *
   * @param  string  $path
   * @return mixed
   */
  protected function getFile($path)
  {
      return $this->filesystem->get($path);
  }

  /**
   * Get the size of the file located at the given path.
   *
   * @param  string  $path
   * @return mixed
   */
  protected function getFileSize($path)
  {
      return $this->filesystem->size($path);
  }

  /**
   * Construct the body of the JSON response.
   *
   * @param  string  $filename
   * @param  string  $mime
   * @param  string  $path
   * @param  string  $pathThumb
   * @return array
   */
  protected function setJsonBody($filename, $mime, $path, $pathThumb)
  {
      $this->jsonBody = [
          'images' => [
              'filename' => $filename,
              'mime' => $mime,
              'size' => $this->getFileSize($path),
              'path' => $path,
              'pathTumb' => $pathThumb
          ]
      ];
  }

  public function getJsonBody()
  {
    return $this->jsonBody;
  }

  /**
   * handle 
   * 
   * @param UploadedFile $image image 
   * 
   * @return void
   */
  public function handle(UploadedFile $image)
  {
    $mime = $file->getMimeType();
    $filename = $this->makeFilename();
    $path = $this->config('image.upload_path') . '/' . $filename;
    $pathThumb = $this->config('image.thumb_path') . '/' . $filename;
    $thumbWidth = $this->config('image.thumb_width');

    //We upload the image first to the upload folder, then get make a thumbnail from the uploaded image
    $upload = $image->move(Config::get('image.upload_path'), $filename);
    
    //Our model that we've created is named Images, this library has an alias named Image, don't mix them two!
    //These parameters are related to the image processing class that we've included, not really related to Laravel
    $this->imageManip->make($path)
                     ->resize($thumbWidth, null)
                     ->save($pathThumb);

    $this->succeeds = $this->imageManip->succeeds();
    
    if($this->succeeds) 
    {
      $this->setJsonBody($filename, $mime, $path, $pathThumb);
    } else {
      $this->errors = $this->imageManip->errors();
    }

    return $this;
  }
}

