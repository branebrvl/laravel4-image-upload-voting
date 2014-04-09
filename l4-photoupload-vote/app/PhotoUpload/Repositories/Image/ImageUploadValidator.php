<?php namespace PhotoUpload\Repositories\Image;

use PhotoUpload\Validation\AbstractValidator;
use PhotoUpload\Validation\ValidationInterface;

/**
 * ImageUploadValidator 
 * 
 * @uses AbstractValidator
 * @uses ValidationInterface
 */
class ImageUploadValidator extends AbstractValidator implements ValidationInterface
{
    protected $rules = [
        'image' => 'required|image'
    ];
}
