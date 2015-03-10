<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 3:17 PM
 */

namespace CloudFS;


class Share {

    private $shareKey;
    private $shareType;
    private $shareName;
    private $url;
    private $shortUrl;
    private $dateCreated;
    private $shareSize;

    public function getShareKey() {
        return $this->shareKey;
    }

    public function getShareType() {
        return $this->shareType;
    }

    public function getShareName() {
        return $this->shareName;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getShortUrl() {
        return $this->shortUrl;
    }

    public function getDateCreated() {
        return $this->dateCreated;
    }

    public function getShareSize() {
        return $this->shareSize;
    }

    private function __construct() {

    }

    public static function getInstance($result) {
        $share = new Share();
        $share->shareKey = $result['share_key'];
        $share->shareType = $result['share_type'];
        $share->shareName = $result['share_name'];
        if (!empty($result['url'])) {
            $share->url = $result['url'];
        }
        $share->shortUrl = $result['short_url'];
        $share->dateCreated = $result['date_created'];
        $share->shareSize = $result['share_size'];
        return $share;
    }

}