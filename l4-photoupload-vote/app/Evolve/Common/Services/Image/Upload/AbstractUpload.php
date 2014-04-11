<?php namespace Evolve\Common\Services\Image\Upload;

use Illuminate\Filesystem\Filesystem; 
use Illuminate\Config\Repository as Config;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Evolve\Common\Services\Image\Manipulation\ImageManipInterface;
use Evolve\Common\Utilities\Helpers;

/**
 * ImageUpload 
 * 
 * @uses ImageUploadInterface
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
   * ImageManip wraper for Intervention package.
   * 
   * @var  \Evolve\Common\Services\Image\Manipulation\Intervention\ImageManip
   */
  public $imageManip;

  /**
  * Filesystem instance.
  *
  * @var \Illuminate\Filesystem\Filesystem      
  */
  protected $filesystem;                

  /**
  * Config instance.
  *
  * @var \Illuminate\Config\Repository
  */
  protected $config;  

  protected $helpers;

  /**
  * Create a new AbstractUpload instance.   
  *
   * @param \Evolve\Common\Services\Image\Manipulation\Intervention\ImageManip $imageManip
  * @param  \Illuminate\Filesystem\Filesystem  $filesystem
  * @param  \Illuminate\Config\Repository $config
  * @return void
  */
  public function __construct(
    ImageManipInterface $imageManip, 
    Filesystem $filesystem, 
    Config $config, 
    Helpers $helpers
  ) {
    $this->imageManip = $imageManip;
    $this->filesystem = $filesystem;           
    $this->config = $config;
    $this->helpers = $helpers;
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

  public function setSize($size)
  {
    $this->size = $size;
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

  public function setPath($path)
  {
    $this->path = $path;
  }

  /**
   * Get the full path from the given partial path.
   *
   * @param  string  $path
   * @return string
   */
  public function getFullPath($path)
  {
    return $this->helpers->getPublicPath() . '/' . $path;
  }

  /**
   * Make a new unique filename
   *
   * @return string
   */
  public function makeFilename()
  {
    return $this->helpers->getRandomName() . ".{$this->extension}";
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
   * @param Symfony\Component\HttpFoundation\File\UploadedFile $image 
   * 
   * @return void
   */
  public function handle($image)
  {
    $filename = $this->makeFilename();
    $path = $this->getPath() . '/' . $filename;

    //These parameters are related to the image processing class that we've included, not really related to Laravel
    $this->imageManip->make($image->getRealPath())
                     ->resize($this->getSize(), $this->getSize())
                     ->save($path, $this->quality);

    $this->succeeds = $this->imageManip->succeeds();
    
    if($this->succeeds) 
    {
      $this->setJsonBody($filename, $image->getMimeType(), $path);
    } else {
      $this->errors = $this->imageManip->errors();
    }

    return $this;
  }
}
