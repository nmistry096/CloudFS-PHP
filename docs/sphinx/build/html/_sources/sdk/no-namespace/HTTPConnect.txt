-----------
HTTPConnect
-----------

.. php:namespace:

.. php:class:: HTTPConnect

    .. php:attr:: curl

    .. php:attr:: boundary

    .. php:attr:: eof

    .. php:attr:: postdata

    .. php:method:: HTTPConnect($session = null)

        :param $session:

    .. php:method:: raw()

    .. php:method:: addHeader($h, $v)

        :param $h:
        :param $v:

    .. php:method:: addMissingHeader($h, $v)

        :param $h:
        :param $v:

    .. php:method:: hasHeader($h, $value = null)

        :param $h:
        :param $value:

    .. php:method:: getHeaders()

    .. php:method:: sendData($data, $len = 0)

        :param $data:
        :param $len:

    .. php:method:: post($url)

        :param $url:

    .. php:method:: read_function($curl, $fd, $length)

        :param $curl:
        :param $fd:
        :param $length:

    .. php:method:: post_multipart($url, $name, $path, $exists)

        :param $url:
        :param $name:
        :param $path:
        :param $exists:

    .. php:method:: put($url)

        :param $url:

    .. php:method:: get($url)

        :param $url:

    .. php:method:: head($url)

        :param $url:

    .. php:method:: delete($url)

        :param $url:

    .. php:method:: getResponse($json = false, $check = true)

        :param $json:
        :param $check:

    .. php:method:: setUserAgent($agent)

        :param $agent:

    .. php:method:: getUserAgent()

    .. php:method:: process($url)

        :param $url:

    .. php:method:: setup()
