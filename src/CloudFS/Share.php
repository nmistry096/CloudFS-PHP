<?php
/**
 * Created by PhpStorm.
 * User: dhanushka
 * Date: 3/10/15
 * Time: 3:17 PM
 */

namespace CloudFS;

/**
 * Represents a bitcasa cloudfs shares.
 * @package CloudFS
 */
class Share {

    private $shareKey;
    private $shareType;
    private $shareName;
    private $url;
    private $shortUrl;
    private $dateCreated;
    private $shareSize;

    /**
     * Retrieves the  share key.
     *
     * @return The share key.
     */
    public function getShareKey() {
        return $this->shareKey;
    }

    /**
     * Retrieves the  share type.
     *
     * @return The share type.
     */
    public function getShareType() {
        return $this->shareType;
    }

    /**
     * Retrieves the  share name.
     *
     * @return The share name.
     */
    public function getName() {
        return $this->shareName;
    }

    /**
     * Retrieves the  url.
     *
     * @return The share url.
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * Retrieves the  short url.
     *
     * @return The short url.
     */
    public function getShortUrl() {
        return $this->shortUrl;
    }

    /**
     * Retrieves the created date.
     *
     * @return The created date.
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * Retrieves the  share size.
     *
     * @return The share size.
     */
    public function getSize() {
        return $this->shareSize;
    }

    /**
     * The share construct.
     */
    private function __construct() {

    }

    /**
     * Retrieves a share instance from the supplied result.
     *
     * @param mixed $result The retrieved result.
     * @return A share instance.
     */
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