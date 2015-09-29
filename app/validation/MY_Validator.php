<?php
class MyValidator {
	public function validateImageFile($attribute, $file_field, $parameters)
    {   
        //TO DO move to stand-alone class
        $maxSize = !empty($parameters[0]) ? $parameters[0] : Config::get('files.default_max_image_file_size');
        if($_FILES){
            if(Input::hasFile($file_field)){
                $avatar = Input::file($file_field);
                $fileInfo = getimagesize($avatar->getRealPath());
                if(!empty($fileInfo[0]) && !empty($fileInfo[0])){
                    if($avatar->getSize() > $maxSize){
                        return false;
                    }
                    else{
                        return true;
                    }
                }
                else
                    return false; 
            }
            return false;
        }
        return true;
    }

    public function validatePassword($attribute, $value, $parameters){
        return Hash::check($value, $parameters[0]);
    }

    public function validateGreater($attribute, $value, $parameters){
        if(intval($value) > intval($parameters[0]))
            return true;
        return false;
    }
}