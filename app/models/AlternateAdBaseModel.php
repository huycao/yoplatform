<?php

class AlternateAdBaseModel extends Eloquent {

    /**
     *     Table name of model used
     *     @var string
     */
    protected $table = 'publisher_alternate_ad';
    protected $fillable = array(
        'name',
        'publisher_id',
        'ad_format_id',
        'url'
    );

    public function getUpdateRules() {
        return array(
            "name"         => "required",
            "ad_format_id" => "required",
            "url"          => "required", 
        );
    }

    public function getUpdateLangs() {
        return array(
            "name.required" => trans("backend::publisher/validation.name.required"),
            "ad_format_id.required" => trans("backend::publisher/validation.adformat.required"),
            "url.required" => trans("backend::publisher/validation.url.required"),
        );
    }

    public function getShowField() {
        return array(
            'name' => array(
                'label' => trans("backend::publisher/text.name"),
                'type' => 'text'
            ),
            'ad_format_id' => array(
                'label' => trans("backend::publisher/text.ad_format"),
                'type' => 'text',
            ),
            'url' => array(
                'label' => trans("backend::publisher/text.alternateadtype"),
                'type' => 'text',
            ),
        );
    }

}
