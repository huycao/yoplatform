<?php

class PublisherLanguageBaseModel extends Eloquent {

	protected $table = 'publisher_language';

    protected $fillable = array(
        'publisher_id',
        'language_name',
        "language_id"
    );			
}
