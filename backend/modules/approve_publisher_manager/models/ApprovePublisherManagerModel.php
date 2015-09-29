<?php

class ApprovePublisherManagerModel extends PublisherBaseModel {

    protected $appends = array('statusText');

    const STATUS_PENDING        = 0;
    const STATUS_ARCHIVED       = 1;
    const STATUS_DISAPPROVED    = 2;
    const STATUS_APPROVED       = 3;

    public function getStatusTextAttribute(){

        $text = "";
        switch ($this->status) {
            case self::STATUS_PENDING:
                $text   = trans("text.pending");
                $class  = "label-warning";
                break;
            case self::STATUS_ARCHIVED:
                $text = trans("text.archived");
                $class  = "label-default";
                break;
            case self::STATUS_DISAPPROVED:
                $text = trans("text.disapproved");
                $class  = "label-danger";
                break;
            case self::STATUS_APPROVED:
                $text = trans("text.approved");
                $class  = "label-success";
                break;
        }

        return '<span class="label '.$class.'">'.$text.'</span>';

    }

    public function getUniqueVisitorFormatAttribute(){
        // return number_format($this->unique_visitor);
        return '<span class="badge badge-info">'.number_format($this->unique_visitor).'</span>';
    }


    public function getUpdateRules(){
        return array(
            "site-name"         =>  "required|min:5",
            "site-url"          =>  "required|min:5",
            "unique-visitor"    =>  "required",

            "page-view"         =>  "required",
            "selected_site-channel"      =>  "required",
            "selected_serve-country"     =>  "required",
        );
    }

    public function getUpdateLangs(){
        return array(
            "site-name.required"         =>  trans("backend::publisher/validation.site-name.required"),
            "site-name.min"              =>  trans("backend::publisher/validation.site-name.min"),
            "site-url.required"          =>  trans("backend::publisher/validation.site-url.required"),
            "site-url.min"               =>  trans("backend::publisher/validation.site-url.min"),
            "site-description.required"  =>  trans("backend::publisher/validation.site-description.required"),
            "site-category.required"     =>  trans("backend::publisher/validation.site-catogory.required"),
            "unique-visitor.required"    =>  trans("backend::publisher/validation.unique-visitor.required"),

            "page-view.required"         =>  trans("backend::publisher/validation.page-view.required"),
           // "daily-view.required"        =>  trans("backend::publisher/validation.daily-view.required"),
            "payment-to.required"        =>  trans("backend::publisher/validation.payment-to.required"),
            "company.required"           =>  trans("backend::publisher/validation.company.required"),
            "company.min"                =>  trans("backend::publisher/validation.company.min"),
            "title.required"             =>  trans("backend::publisher/validation.title.required"),
            "f-name.required"            =>  trans("backend::publisher/validation.f-name.required"),
            "f-name.min"                 =>  trans("backend::publisher/validation.f-name.min"),
            "l-name.required"            =>  trans("backend::publisher/validation.l-name.required"),
            "l-name.min"                 =>  trans("backend::publisher/validation.l-name.min"),
            "address.required"           =>  trans("backend::publisher/validation.address.required"),
            "city.required"              =>  trans("backend::publisher/validation.city.required"),
            "city.min"                   =>  trans("backend::publisher/validation.city.min"),
            "state.required"             =>  trans("backend::publisher/validation.state.required"),
            "postcode.required"          =>  trans("backend::publisher/validation.postcode.required"),
            "selected_site-channel.required"      =>  trans("backend::publisher/validation.site-channel.required"),
            "selected_serve-country.required"     =>  trans("backend::publisher/validation.serve-country.required"),

            "company-name-e.required"              =>  trans("backend::publisher/validation.company-name.required"),
            "tax.required"                       =>  trans("backend::publisher/validation.tax.required"),
            "management-free.required"           =>  trans("backend::publisher/validation.management-free.required"),
            "split-billing.required"             =>  trans("backend::publisher/validation.split-billing.required"),
            "primium-publisher.required"         =>  trans("backend::publisher/validation.primium-publisher.required"),
            "domain-checking.required"           =>  trans("backend::publisher/validation.domain-checking.required"),
            "vast-tag.required"                  =>  trans("backend::publisher/validation.vast-tag.required"),
            "network-publisher.required"         =>  trans("backend::publisher/validation.network-publisher.required"),
            "mobile-ad.required"                 =>  trans("backend::publisher/validation.mobile-ad.required"),
            "access-to-all-channels.required"    =>  trans("backend::publisher/validation.access-to-all-channels.required"),
            "newsletter.required"                =>  trans("backend::publisher/validation.newsletter.required"),
            "enable-report-by-model.required"    =>  trans("backend::publisher/validation.enable-report-by-model.required"),
        );
       
    }

    public function getUpdateProfileRules(){
        return array(
            "password"         =>  "required|min:5",
            "c-password"       =>  "required|min:5|same:password",
            "f-name"           =>  "required|min:3",
            "l-name"           =>  "required|min:3",
            "email"            =>  "required|email|min:3"
        );
    }

    public function getUpdateProfileLangs(){
        return array(
            "password.required"         =>  trans("backend::publisher/validation.password.required"),
            "password.min"              =>  trans("backend::publisher/validation.password.min"),
            "c-password.required"       =>  trans("backend::publisher/validation.c-password.required"),
            "c-password.min"            =>  trans("backend::publisher/validation.c-password.min"),
            "c-password.same"           =>  trans("backend::publisher/validation.c-password.same"),
            "f-name.required"           =>  trans("backend::publisher/validation.f-name.required"),
            "f-name.min"                =>  trans("backend::publisher/validation.f-name.min"),
            "l-name.required"           =>  trans("backend::publisher/validation.l-name.required"),
            "l-name.min"                =>  trans("backend::publisher/validation.l-name.min"),
            "email.required"            =>  trans("backend::publisher/validation.email.required"),
            "email.email"               =>  trans("backend::publisher/validation.email.email"),
            "email.min"                 =>  trans("backend::publisher/validation.email.min"),
        );   
    }

    public function getShowField(){        
        return array(
            'company'         =>  array(
                'label'         =>  trans("backend::publisher/text.company"),
                'type'          =>  'text'
            ),
            'site_url'         =>  array(
                'label'         =>  trans("backend::publisher/text.site_url"),
                'type'          =>  'text'
            ),
            'pageview'         =>  array(
                'label'         =>  trans("backend::publisher/text.pageview"),
                'type'          =>  'text'
            ),
            'unique_visitor'  =>  array(
                'label'         =>  trans("backend::publisher/text.unique_visitor"),
                'type'          =>  'text',
                'alias'         => 'uniqueVisitorFormat'
            ),            
            'email'  =>  array(
                'label'         =>  trans("backend::publisher/text.email"),
                'type'          =>  'text',
                'alias'         => 'email'
            ),
            'status'  =>  array(
                'label'         =>  trans("backend::publisher/text.status"),
                'type'          =>  'text',
                'alias'         => 'statusText'
            ),
            'created_at'    =>  array(
                'label'         =>  trans("backend::publisher/text.date_registered"),
                'type'          =>  'text'
            )
        );   
    }

    public function getSearchField(){
        return array(
            'title'         =>  trans("text.name")
        );
    }

    public function scopeSearch($query, $searchData = array(),$status='')
    {
        if( !empty($searchData) ){

            $idCountry  =$searchData[0]['value'];
            $idCate     =$searchData[1]['value'];
            $typeName   =$searchData[2]['value'];
            $keyword    =$searchData[3]['value'];
            $status     =$searchData[4]['value'];

            if(!empty($idCountry))
                $query->where('country', $idCountry);

            if(!empty($idCate))
                $query->where('category', $idCate);
            
            if(isset($status) && $status !=-1){
                $query->where('status', $status);               
            }

            if(!empty($keyword)){
                if($typeName=="company"){
                    $query->where("company","LIKE",DB::raw("'%{$keyword}%'"));
                }else
                    $query->where('email', 'LIKE', DB::raw("'%{$keyword}%'"));
            }
            
        }else{
            if($status==Config::get('backend.publisher_approved')){
                $query=$query->where('status',Config::get('backend.publisher_approved'));
            }else
                $query->where('status','0');
        }      
        
        return $query;
    }

    
    public function getCategoryByIdAttribute(){
        $modelCate=new CategoryBaseModel;      
        $item=$modelCate->where('id',$this->category)->select('id','name')->first();
        if(!empty($item)) return $item->name;
        else return FALSE;
    }
    public function user(){
        return $this->belongsTo('User');        
    }

    public function scopeGetListByDate($query,$dateStart,$dateEnd){
        $item=$query->whereBetween('updated_at',[$dateEnd,$dateStart])->get();
        return $item;
    }

    public function relationCategory(){
        return $this->belongsTo('CategoryBaseModel','category');
    }


}
