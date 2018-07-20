<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/23/17
 * Time: 3:13 PM
 */

namespace Javra\Javraevents\Api\Data;


interface PostInterface
{

    const POST_ID       = 'post_id';
    const URL_KEY       = 'url_key';
    const TITLE         = 'title';
    const CONTENT       = 'content';
    const IMAGE         ='image';
    const CREATION_TIME = 'creation_time';
    const CREATED_BY    ='created_by';
    const START_DATE    ='start_date';
    const END_DATE      ='end_date';
    const TYPE          ='type';
    const UPDATE_TIME   = 'update_time';
    const LOCATION     = 'location';
    const COUNTRY     = 'country';
    const CITY     = 'city';
    const SHORT_DESCRIPTION     = 'short_description';
    const IS_ACTIVE     = 'is_active';

    /*
     *Get ID
     * @return int|Null
     */
    public function getId();

    public function getUrlKey();

    public function getTitle();

    public function getContent();

    public function getImage();

    public function getCreatedBy();

    public function getLocation();

    public function getCountry();

    public function getCity();

    public function getShortDescription();

    public function getType();

    public function getCreationTime();

    public function getUpdateTime();

    public function getStartDate();

    public function getEndDate();

    public function isActive();


    public function setId($id);

    public function setUrlKey($url_key);

    public function setTitle($title);

    public function setContent($content);

    public function setImage($image);

    public function setCreatedBy($created_by);

    public function setLocation($location);

    public function setCountry($country);

    public function setCity($city);

    public function setShortDescription($short_description);

    public function setType($type);

    public function setCreationTime($creation_time);

    public function setUpdateTime($update_time);

    public function setStartDate($start_date);

    public function setEndDate($end_date);

    public function setIsActive($is_active);

}