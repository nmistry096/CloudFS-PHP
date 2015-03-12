<?php

namespace CloudFS\Utils;

/**
 * Constants used in REST api requests
 */
abstract class BitcasaConstants {

    /**
     * The api request uri components.
     */
    const HTTPS = "https://";
    const API_VERSION_2 = "/v2";
    const FORESLASH = "/";

    const UTF_8_ENCODING = "UTF-8";

    /**
     * Http headers for http requests.
     */
    const HEADER_CONTENT_TYPE = "Content-Type";
    const HEADER_CONTENT_TYPE_APP_URLENCODED = "application/x-www-form-urlencoded; charset=\"utf-8\"";
    const HEADER_ACCEPT_CHARSET = "Accept-Charset";
    const HEADER_XAUTH = "XAuth";
    const HEADER_RANGE = "Range";
    const HEADER_CONNECTION = "Connection";
    const HEADER_CONNECTION_KEEP_ALIVE = "Keep-Alive";
    const HEADER_ENCTYPE = "ENCTYPE";
    const HEADER_ENCTYPE_MULTIPART = "multipart/form-data";
    const HEADER_CONTENT_TYPE_MULTIPART_BOUNDARY = "multipart/form-data;boundary=";
    const HEADER_FILE = "file";
    const HEADER_AUTORIZATION = "Authorization";
    const HEADER_DATE = "Date";

    /**
     * The http request methods for HTTPConnect.
     */
    const REQUEST_METHOD_GET = "GET";
    const REQUEST_METHOD_POST = "POST";
    const REQUEST_METHOD_PUT = "PUT";
    const REQUEST_METHOD_DELETE = "DELETE";
    const REQUEST_METHOD_HEAD = "HEAD";

    /**
     * Methods supported in request url for accessing bitcasa api.
     */
    const METHOD_AUTHENTICATE = "/authenticate";
    const METHOD_OAUTH2 = "/oauth2";
    const METHOD_ACCESS_TOKEN = "/access_token";
    const METHOD_AUTHORIZE = "/authorize";
    const METHOD_ADMIN = "/admin";
    const METHOD_CLOUDFS = "/cloudfs";
    const METHOD_CUSTOMERS = "/customers/";
    const METHOD_TOKEN = "/token";
    const METHOD_ITEMS = "/files";  // TODO should change this path to /v2/filesystem/root/<path>/meta after REST fix
    const METHOD_FOLDERS = "/folders";
    const METHOD_FILES = "/files";
    const METHOD_USER = "/user";
    const METHOD_PROFILE = "/profile/";
    const METHOD_META = "/meta";
    const METHOD_PING = "/ping";
    const METHOD_SHARES = "/shares/";
    const METHOD_UNLOCK = "/unlock";
    const METHOD_INFO = "/info";
    const METHOD_HISTORY = "/history";
    const METHOD_TRASH = "/trash";
    const METHOD_VERSIONS = "/versions";

    /**
     * Parameters supported in request url for accessing bitcasa api.
     */
    const PARAM_CLIENT_ID = "client_id";
    const PARAM_REDIRECT = "redirect";
    const PARAM_USER = "user";
    const PARAM_PASSWORD = "password";
    const PARAM_CURRENT_PASSWORD = "current_password";
    const PARAM_SECRET = "secret";
    const PARAM_CODE = "code";
    const PARAM_RESPONSE_TYPE = "response_type";
    const PARAM_REDIRECT_URI = "redirect_uri";
    const PARAM_GRANT_TYPE = "grant_type";
    const PARAM_PATH = "path";
    const PARAM_FOLDER_NAME = "folder_name";
    const PARAM_ACCESS_TOKEN = "access_token";
    const PARAM_DEPTH = "depth";
    const PARAM_FILTER = "filter";
    const PARAM_LATEST = "latest";
    const PARAM_CATEGORY = "category";
    const PARAM_ID = "id";
    const PARAM_INDIRECT = "indirect";
    const PARAM_FILENAME = "filename";
    const PARAM_EXISTS = "exists";
    const PARAM_OPERATION = "operation";
    const PARAM_USERNAME = "username";
    const PARAM_VERSION = "version";
    const PARAM_VERSIONS = "versions";
    const PARAM_VERSION_CONFLICT = "version-conflict";
    const PARAM_COMMIT = "commit";
    const PARAM_FORCE = "force";
    const PARAM_TRUE = "true";
    const PARAM_FALSE = "false";
    const PARAM_START = "start";
    const PARAM_STOP = "stop";
    const PARAM_EMAIL = "email";
    const PARAM_FIRSTNAME = "first_name";
    const PARAM_LASTNAME = "last_name";

    /**
     * Http body variables to be used with http requests.
     */
    const BODY_FOLDERNAME = "folder_name";
    const BODY_FILE = "file";
    const BODY_FROM = "from";
    const BODY_TO = "to";
    const BODY_EXISTS = "exists";
    const BODY_NAME = "name";
    const BODY_PATH = "path";
    const BODY_RESTORE = "restore";
    const BODY_RESCUE_PATH = "rescue-path";
    const BODY_RECREATE_PATH = "recreate-path";

    /**
     * Operation available for bitcasa items.
     */
    const OPERATION_COPY = "copy";
    const OPERATION_MOVE = "move";
    const OPERATION_CREATE = "create";
    const OPERATION_PROMOTE = "promote";

    /**
     * Actions to take if an item already exists.
     */
    const EXISTS_FAIL = "fail";
    const EXISTS_OVERWRITE = "overwrite";
    const EXISTS_RENAME = "rename";

    /**
     * Actions to take if an item version conflict occurs.
     */
    const VERSION_FAIL = "fail";
    const VERSION_IGNORE = "ignore";

    /**
     * Actions to take if an item already exists while restoring.
     */
    const RESTORE_FAIL = "fail";
    const RESTORE_RESCUE = "rescue";
    const RESTORE_RECREATE = "recreate";

    /**
     * Variables used when retrieving item version.
     */
    const START_VERSION = "start-version";
    const STOP_VERSION = "stop-version";
    const LIMIT = "limit";

    /**
     * Update progress interval.
     */
    const PROGRESS_UPDATE_INTERVAL = 2000;

    /**
     * Web request related strings.
     */
    const DATE_FORMAT = "%a, %e %b %Y %H:%M:%S %Z";
    const FORM_URLENCODED = "application/x-www-form-urlencoded; charset=\"utf-8\"";
    const OAUTH_TOKEN = "/oauth2/token";
}