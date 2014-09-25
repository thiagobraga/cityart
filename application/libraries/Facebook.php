<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once APPPATH . 'libraries/facebook/base_facebook.php';

/**
 * Extends the BaseFacebook class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class Facebook extends BaseFacebook
{

    /**
     * Cookie prefix
     */
    const FBSS_COOKIE_NAME = 'fbss';

    /**
     * We can set this to a high number because the main session
     * expiration will trump this.
     */
    const FBSS_COOKIE_EXPIRE = 31556926; // 1 year

    /**
     * Stores the shared session ID if one is set.
     *
     * @var string
     */
    protected $sharedSessionID;

    /**
     * Identical to the parent constructor, except that
     * we start a PHP session to store the user ID and
     * access token if during the course of execution
     * we discover them.
     *
     * @param array $config the application configuration. Additionally
     * accepts "sharedSession" as a boolean to turn on a secondary
     * cookie for environments with a shared session (that is, your app
     * shares the domain with other apps).
     *
     * @see BaseFacebook::__construct
     */
    public function __construct($config)
    {
        if (!session_id()) {
            session_start();
        }

        parent::__construct($config);
        if (!empty($config['sharedSession'])) {
            Facebook::initSharedSession();

            // re-load the persisted state, since parent
            // attempted to read out of non-shared cookie
            $state = Facebook::getPersistentData('state');
            if (!empty($state)) {
                $this->state = $state;
            } else {
                $this->state = null;
            }
        }

        // Call in constructor the method that defines
        // the allowed_categories array.
        Facebook::setAllowedCategories();
    }

    /**
     * Supported keys for persistent data
     *
     * @var array
     */
    protected static $kSupportedKeys = array(
        'state',
        'code',
        'access_token',
        'user_id'
    );

    /**
     * Initiates Shared Session
     */
    protected function initSharedSession()
    {
        $cookie_name = $this->getSharedSessionCookieName();
        if (isset($_COOKIE[$cookie_name])) {
            $data = $this->parseSignedRequest($_COOKIE[$cookie_name]);
            if (
                $data && !empty($data['domain'])
                && self::isAllowedDomain($this->getHttpHost(), $data['domain'])
            ) {
                // good case
                $this->sharedSessionID = $data['id'];
                return;
            }
            // ignoring potentially unreachable data
        }

        // evil/corrupt/missing case
        $base_domain = $this->getBaseDomain();
        $this->sharedSessionID = md5(uniqid(mt_rand(), true));
        $cookie_value = $this->makeSignedRequest(
            array(
                'domain' => $base_domain,
                'id' => $this->sharedSessionID,
            )
        );
        $_COOKIE[$cookie_name] = $cookie_value;
        if (!headers_sent()) {
            $expire = time() + self::FBSS_COOKIE_EXPIRE;
            setcookie($cookie_name, $cookie_value, $expire, '/', '.'.$base_domain);
        } else {
            // @codeCoverageIgnoreStart
            self::errorLog(
                'Shared session ID cookie could not be set! You must ensure you '.
                'create the Facebook instance before headers have been sent. This '.
                'will cause authentication issues after the first request.'
            );
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Provides the implementations of the inherited abstract
     * methods. The implementation uses PHP sessions to maintain
     * a store for authorization codes, user ids, CSRF states, and
     * access tokens.
     */

  /**
   * {@inheritdoc}
   *
   * @see BaseFacebook::setPersistentData()
   */
  protected function setPersistentData($key, $value)
  {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to setPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    $_SESSION[$session_var_name] = $value;
  }

  /**
* {@inheritdoc}
*
* @see BaseFacebook::getPersistentData()
*/
  protected function getPersistentData($key, $default = false)
  {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to getPersistentData.');
      return $default;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    return isset($_SESSION[$session_var_name]) ?
      $_SESSION[$session_var_name] : $default;
  }

  /**
* {@inheritdoc}
*
* @see BaseFacebook::clearPersistentData()
*/
  protected function clearPersistentData($key)
  {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to clearPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    if (isset($_SESSION[$session_var_name])) {
      unset($_SESSION[$session_var_name]);
    }
  }

  /**
* {@inheritdoc}
*
* @see BaseFacebook::clearAllPersistentData()
*/
  protected function clearAllPersistentData()
  {
    foreach (self::$kSupportedKeys as $key) {
      Facebook::clearPersistentData($key);
    }
    if ($this->sharedSessionID) {
      Facebook::deleteSharedSessionCookie();
    }
  }

  /**
* Deletes Shared session cookie
*/
  protected function deleteSharedSessionCookie()
  {
    $cookie_name = Facebook::getSharedSessionCookieName();
    unset($_COOKIE[$cookie_name]);
    $base_domain = Facebook::getBaseDomain();
    setcookie($cookie_name, '', 1, '/', '.'.$base_domain);
  }

  /**
* Returns the Shared session cookie name
*
* @return string The Shared session cookie name
*/
  protected function getSharedSessionCookieName()
  {
    return self::FBSS_COOKIE_NAME . '_' . $this->getAppId();
  }

  /**
* Constructs and returns the name of the session key.
*
* @see setPersistentData()
* @param string $key The key for which the session variable name to construct.
*
* @return string The name of the session key.
*/
  protected function constructSessionVariableName($key)
  {
    $parts = array('fb', $this->getAppId(), $key);
    if ($this->sharedSessionID) {
      array_unshift($parts, $this->sharedSessionID);
    }
    return implode('_', $parts);
  }

    /**
     * [getMostLikedPhotos description]
     *
     * @param  [type]  $id    [description]
     * @param  integer $limit [description]
     * @return [type]
     */
    public function getMostLikedPhotos($id, $limit = 20, $exception_list)
    {
        $get_top_photos =
            "SELECT  images, caption, object_id, like_info
            FROM     photo
            WHERE    owner = $id AND NOT (object_id IN ($exception_list))
            ORDER BY like_info.like_count DESC
            LIMIT    $limit";

        return Facebook::fql($get_top_photos);
    }

    /**
     * [getPhotosWithTag description]
     *
     * @param  [type]  $id    [description]
     * @param  integer $limit [description]
     * @return [type]
     */
    public function getPhotosWithTag($id, $limit = 20, $exception_list)
    {
        $query1 = "SELECT object_id FROM photo WHERE owner=$id AND NOT (object_id IN ($exception_list))";
        $query2 = "SELECT object_id FROM photo_tag WHERE object_id IN (SELECT object_id FROM #query1)";
        $query3 = "SELECT object_id, like_info, images FROM photo WHERE object_id IN (SELECT object_id FROM #query2) ORDER BY like_info.like_count DESC LIMIT $limit";

        $query  = json_encode(
            array(
                'query1' => $query1,
                'query2' => $query2,
                'query3' => $query3
            )
        );

        // get user access_token
        $access_token = Facebook::getAccessToken();

        // run fql query
        $fql_query_url = 'https://graph.facebook.com/'
            . 'fql?q=' . urlencode($query)
            . '&access_token=' . $access_token;

        $fql_query_result = file_get_contents($fql_query_url);

        // @TODO: Update PHP to >= 5.4 to use the new json_decode
        // json_decode($json, false, 512, JSON_BIGINT_AS_STRING)
        // Further information: http://php.net/manual/en/function.json-decode.php
        $start = ':';
        $end   = '}';

        $character = '';
        $counter   = 0;
        $total     = strlen($fql_query_result);
        $new_json  = '';

        // Adding slashes for ids (json_decode converts big ints to (double) type)
        // Since we consider that object_id value is a string, we must add '"'
        for($counter = 0; $counter < $total; $counter++) {

            $character = $fql_query_result[$counter];

            if($character === $end) {
                $new_json .= '"';
            }

            $new_json .= $character;

            if($character === $start) {
                $new_json .= '"';
            }
        }

    $fql_query_result = $new_json;
        $fql_query_obj    = (object) json_decode($fql_query_result, true); print_r($fql_query_obj->data);
        $fql_query_obj    = $fql_query_obj->data;

        return $fql_query_obj[2]['fql_result_set'];
    }

    /**
     * [selectPhotos description]
     *
     * @param  [long] $id        Facebook's page id
     * @param  [int]  $limit     Number of photos to be retrieved
     * @param  [array]$exception List of id's to forget (because we already have)
     * @return [array]           List of photos
     */
    public function selectPhotos($id, $limit, $exception)
    {
        if ($exception) {
            $exception_list = implode(",", $exception);
        }

        $result1 = $this->getPhotosWithTag((string) $id, (string) $limit, (string)$exception_list);
        $limit   = $limit - count($result1);
        $result2 = $this->getMostLikedPhotos((string) $id, (string) $limit, (string) $exception_list);

        return array_merge((array) $result1, (array) $result2);
    }

    /** {{AQUI}} Finish it
     * Returns list of friends of friends that are using the app
     * @param  integer $id    Facebook ID
     * @param  integer $limit Number of friends to return
     * @param  integer $depth Depth of search
     * @return Array          List of friends
     */
    public function getFriendsOfFriends($id)
    {
        return null;

        $friends_of_friends = array();

        // All my friends that use this app
        $my_friends = Facebook::fql("SELECT uid, name
            FROM user
            WHERE
                is_app_user AND
                uid IN (
                    SELECT uid2
                    FROM friend
                    WHERE uid1 = $id
                )");

        $query = array();

        // Friends of my friends
        // {{AQUI}} Implement multi-query
        foreach ($my_friends as $friend) {
            $friend_id = $friend['uid'];

            array_push($query, "SELECT uid, name FROM user WHERE is_app_user AND uid IN (
                SELECT uid2
                FROM friend
                WHERE uid1 = $friend_id AND uid2 <> $id
            )");
            //$result = Facebook::fql($query);
            //$friends_of_friends = array_merge($friends_of_friends, $result);
        }

        // Excluding duplicates
        $return = array();
        foreach ($friends_of_friends as $friend) {
            // Saving friend
            $return[$friend['uid']] = $friend;
        }

        // Excluding mutual friends
        $is_mutual = false;
        foreach ($return as $key => $friend) {
            // Verify if is a mutual friend
            $is_mutual = false;
            foreach ($my_friends as $my_friend) {
                if ($friend['uid'] == $my_friend['uid']) {
                    $is_mutual = true;
                    break;
                }
            }

            if ($is_mutual) unset($return[$key]);
        }

        return $return;
    }

    /**
     * Performs a FQL query
     * @param  [string] $query Query in FQL format
     * @return [Array]         Array containing the FQL query response
     */
    public function fql($query)
    {
        $fql_query_obj = Facebook::api(
            array(
                'method' => 'fql.query',
                'query' => $query
            )
        );

        return $fql_query_obj;
    }

    /**
     * Allowed category pages to get from Facebook.
     * This array is defined in Barpedia configuration file.
     *
     * @var {Array}
     */
    public $allowed_categories = array();

    /**
     * Global configurations array from Barpedia configuration file.
     *
     * @var {Array}
     */
    public $config_global = array();

    /**
     * RegEx containing the names of allowed categories with generic names.
     *
     * @var {String}
     */
    public $regex = '/Arts\/entertainment\/nightlife|Local business|Food\/grocery/';

    /**
     * Set the categories based in Barpedia configuration file
     *
     * @return {Void}
     */
    public function setAllowedCategories()
    {
        $CI                       =& get_instance();
        $this->config_global      = $CI->config->item('global');
        $this->allowed_categories = $this->config_global['facebook']['allowed_categories'];
    }

    /**
     * Get Pages whose user is admin
     * TODO: Test the new implementation. Because of the error of access token, I could not test.
     *
     * @return {Array} with information about the pages
     */
    public function getPages()
    {
        $is_admin_pages = array();

        if (get_cookie('local_locale')) {
            $locale = get_cookie('local_locale');
        } else {
            $locale = $this->config_global['languages']['default']['file'];
        }

        // Getting data
        $pages = Facebook::api(
            '/me/accounts', array(
                'fields' => 'likes, name, category, category_list, perms, id, is_published',
                'locale' => $locale
            )
        );

        foreach ($pages['data'] as $page) {
            $is_admin     = array_search('ADMINISTER', $page['perms']) !== false;
            $is_published = $page['is_published'];

            if (preg_match($this->regex, $page['category'])) {
                if ($page['category_list']) {
                    foreach ($page['category_list'] as $subcategory) {
                        $subcategory_array[] = $subcategory['name'];
                    }
                    $is_allowed_page = array_intersect($subcategory_array, $this->allowed_categories);
                }
            } else {
                $is_allowed_page = array_search($page['category'], $this->allowed_categories) !== false;
            }

            // Recovering profile's picture
            $picture = (object) $this->api(
                '/' . $page['id'] . '/picture?type=normal&width=48&height=48&redirect=false'
            );
            $page['picture'] = $picture->data['url'];

            // Verifying if page belongs to an allowed category
            if ($is_admin && $is_published) {

                if ($is_allowed_page) {
                    $page['is_allowed'] = true;
                }

                array_push($is_admin_pages, $page);
            }
        }

        return $is_admin_pages;
    }

    /**
     * Check if user has pages
     * Used in modal after user login.
     *
     * @return boolean Return true if has, and false if not
     */
    public function hasPage($me = '')
    {
        if ($me == '') {
            $me = 'me()';
        }

        $allowed_categories = "'" . strtoupper(
            implode("','", $this->allowed_categories)
        ) . "'";

        $query =
            "SELECT page_id, perms, type, role
            FROM    page_admin
            WHERE   uid = $me
            AND     type IN ($allowed_categories)";

        if (get_cookie('local_locale')) {
            $locale = get_cookie('local_locale');
        } else {
            $locale = $this->config_global['languages']['default']['file'];
        }

        return count(Facebook::api(
            array(
                'method' => 'fql.query',
                'query' => $query,
                'locale' => $locale
            )
        )) > 0;
    }

    /**
     * Check if link belongs to a Facebook page.
     * Used in New Bar page in add via Facebook feature.
     *
     * @param  [type]  $arg [description]
     * @return boolean      [description]
     */
    public function isPage($arg)
    {
        $subcategory_array = array();

        // Verifying link
        try {
            $page = (object) Facebook::api(
                '/' . $arg, array(
                    'fields' => array('name', 'category', 'category_list', 'id', 'link')
                )
            );

            // Check if the page has some of the allowed categories.
            // If the page has "Local business" or "Arts/entertainment/nightlife",
            // check the subcategories too.
            if (preg_match($this->regex, $page->category)) {
                foreach ($page->category_list as $subcategory) {
                    $subcategory_array[] = $subcategory['name'];
                }
                $is_allowed_page = array_intersect($subcategory_array, $this->allowed_categories);
            } else {
                $is_allowed_page = array_search($page->category, $this->allowed_categories) !== false;
            }

            // Get internationalizated category
            if (get_cookie('local_locale')) {
                $locale = get_cookie('local_locale');
            } else {
                $locale = $this->config_global['languages']['default']['file'];
            }

            $page_i18n = (object) Facebook::api(
                '/' . $arg, array(
                    'fields' => array('category', 'category_list'),
                    'locale' => $locale
                )
            );

            // Is a fanpage
            if ($is_allowed_page) {
                return (object) array(
                    'is_page'            => true,
                    'id'                 => $page->id,
                    'name'               => $page->name,
                    'link'               => $page->link,
                    'category'           => $page->category,
                    'category_list'      => $page->category_list,
                    'category_i18n'      => $page_i18n->category,
                    'category_list_i18n' => $page_i18n->category_list
                );

            // Its category is not allowed
            } else {
                // Check if the page has some of the allowed categories.
                // If the page has "Local business" or "Arts/entertainment/nightlife",
                // check the subcategories too.
                if (preg_match($this->regex, $page->category)) {
                    return (object) array(
                        'is_page'            => true,
                        'id'                 => $page->id,
                        'name'               => $page->name,
                        'link'               => $page->link,
                        'category'           => $page->category,
                        'category_list'      => $page->category_list,
                        'category_i18n'      => $page_i18n->category,
                        'category_list_i18n' => $page_i18n->category_list,
                        'error'              => 'CATEGORY_NOT_ALLOWED'
                    );
                } else {
                    return (object) array(
                        'is_page'       => true,
                        'id'            => $page->id,
                        'name'          => $page->name,
                        'link'          => $page->link,
                        'category'      => $page->category,
                        'category_i18n' => $page_i18n->category,
                        'error'         => 'CATEGORY_NOT_ALLOWED'
                    );
                }
            }

        // Is not a fanpage
        } catch (Exception $e) {

            try {

                // Is profile
                $profile = (object) $this->api(
                    '/' . $arg, array('fields' => array('id, name, link'))
                );

                return (object) array(
                    'is_page' => false,
                    'id'      => $profile->id,
                    'name'    => $profile->name,
                    'link'    => $profile->link,
                    'error'   => 'IS_PROFILE'
                );

            // Invalid link
            } catch (Exception $e) {

                return (object) array(
                    'is_page' => false,
                    'id'      => $arg,
                    'name'    => $arg,
                    'link'    => $arg,
                    'category'=> false,
                    'error'   => 'INVALID_LINK'
                );
            }
        }
    }

}
