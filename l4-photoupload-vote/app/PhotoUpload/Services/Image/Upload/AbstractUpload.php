<?php namespace PhotoUpload\Services\Image\Upload;

/**
 * ImageUpload 
 * 
 * @uses ImageUploadInterface
 * @author Branislav Vladisavljev 
 */
class AbstractUpload implements ImageUploadInterface {

  /**
  * If there are any errors, they will be here
  *
  * @var array
  */
  protected $errors = [];  

  /**
   * succeeds 
   * 
   * @var mixed
   */
  protected $succeeds = false;

  /**
   * jsonBody 
   * 
   * @var mixed
   */
  protected $jsonBody;

  /**
   * The extension to use for image files.
   *
   * @var string
   */
  protected $extension = 'jpg';

  /**
   * The dimensions to resize the image to.
   *
   * @var int
   */
  protected $size = 160;

  /**
   * The path where the image should be saved. 
   * 
   * @var mixed
   */
  protected $path;

  /**
   * The quality the image should be saved in.
   *  
   * @var int
   */ 
  protected $quality = 65;

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
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return int 
   */
  protected function getSize()
  {
    return $this->size;
  }

  /**
   * Get size for image mainupulation resize action. 
   * 
   * 
   * @return string
   */
  protected function getPath()
  {
    return $this->path;
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
  protected function setJsonBody($filename, $mime, $path)
  {
      $this->jsonBody = [
          'images' => [
              'filename' => $filename,
              'mime' => $mime,
              'size' => $this->getFileSize($path),
              'path' => $path,
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
    $filename = $this->makeFilename();
    $path = getSize() . '/' . $filename;

    //These parameters are related to the image processing class that we've included, not really related to Laravel
    $this->imageManip->make($image->getRealPath())
                     ->resize(getSize(), null)
                     ->save(getPath(), $this->quality);

    $this->succeeds = $this->imageManip->succeeds();
    
    if($this->succeeds) 
    {
      $this->setJsonBody($filename, $this->getMimeType(), $path);
    } else {
      $this->errors = $this->imageManip->errors();
    }

    return $this;
  }
}

