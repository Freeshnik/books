<?php

namespace App;

class Request
{
    public const METHOD_GET     = 1;
    public const METHOD_POST    = 2;
    public const METHOD_PUT     = 3;
    public const METHOD_DELETE  = 4;
    public const METHOD_OPTIONS = 5;
    public const METHOD_HEAD    = 6;
    public const METHOD_PATCH   = 7;

    /**
     * @var static
     */
    protected static $instance;

    /**
     * @return self|static
     */
    public static function i()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $str
     * @return string
     */
    public function strEncode($str)
    {
        $str = rawurldecode($str);
        $str = urldecode($str);
        $str = urlencode($str);

        return $str;
    }

    public function get($key = null, $default_value = null)
    {
        return \Yii::$app->request->get($key, $default_value);
    }

    public function post($key = null, $default_value = null)
    {
        return \Yii::$app->request->post($key, $default_value);
    }

    /**
     * @param string $key
     * @param int $source
     * @param mixed|null $default_value
     * @return mixed|null
     */
    protected function getParam($key, $source = self::METHOD_GET, $default_value = null)
    {
        if ($source == self::METHOD_GET) {
            return $this->get($key, $default_value);
        }

        return $this->post($key, $default_value);
    }

    /**
     * @param string $key
     * @param int $source
     * @param mixed|null $default_value
     * @param null|int $max_value максимальное значение
     * @return int|null
     */
    protected function getParamInt($key, $source = self::METHOD_GET, $default_value = null, $max_value = null)
    {
        $value = $this->getParam($key, $source);
        if (!is_numeric($value)) {
            return $default_value;
        }
        $value_int = (int) $this->getParam($key, $source);

        if (is_numeric($max_value) && $value_int > $max_value) {
            return $max_value;
        }

        return $value_int;
    }

    /**
     * @param $key
     * @param null $default_value
     * @param null $max_value
     * @return int|null
     */
    public function getInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param $key
     * @param null $default_value
     * @param null $max_value
     * @return int|null
     */
    public function postInt($key, $default_value = null, $max_value = null)
    {
        return $this->getParamInt($key, self::METHOD_POST, $default_value, $max_value);
    }

    /**
     * @param $key
     * @param int $source
     * @param null $default_value
     * @param null $max_value
     * @return float|mixed|null
     */
    protected function getParamFloat($key, $source = self::METHOD_GET, $default_value = null, $max_value = null)
    {
        $value = $this->getParam($key, $source);
        $value = str_replace(',', '.', $value);
        if (!is_numeric($value)) {
            return $default_value;
        }
        $value_float = $this->getParam($key, $source);
        $value_float = (float) str_replace(',', '.', $value_float);
        if (is_numeric($max_value) && $value_float > $max_value) {
            return $max_value;
        }

        return $value_float;
    }

    /**
     * @param $key
     * @param null $default_value
     * @param null $max_value
     * @return float|mixed|null
     */
    public function getFloat($key, $default_value = null, $max_value = null)
    {
        return $this->getParamFloat($key, self::METHOD_GET, $default_value, $max_value);
    }

    /**
     * @param $key
     * @param null $default_value
     * @param null $max_value
     * @return float|mixed|null
     */
    public function postFloat($key, $default_value = null, $max_value = null)
    {
        return $this->getParamFloat($key, self::METHOD_POST, $default_value, $max_value);
    }

    /**
     * @param string $key
     * @param array|int|null $source
     * @param mixed|null $default_value
     * @return mixed|null
     */
    protected function getParamStr($key, $source = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $source);
        if (!is_string($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param $key
     * @param null $default_value
     * @return mixed|null
     */
    public function getStr($key, $default_value = null)
    {
        return $this->getParamStr($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param $key
     * @param null $default_value
     * @return mixed|null
     */
    public function postStr($key, $default_value = null)
    {
        return $this->getParamStr($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param $key
     * @param int $source
     * @param array $default_value
     * @return array|mixed|null
     */
    protected function getParamArray($key, $source = self::METHOD_GET, array $default_value = [])
    {
        $value = $this->getParam($key, $source);
        if (!is_array($value)) {
            return $default_value;
        }

        return $value;
    }

    /**
     * @param $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function getArray($key, array $default_value = [])
    {
        return $this->getParamArray($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function postArray($key, array $default_value = [])
    {
        return $this->getParamArray($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param $key
     * @param int $source
     * @param array $default_value
     * @return array
     */
    protected function getParamArrayInt($key, $source = self::METHOD_GET, array $default_value = [])
    {
        $value = $this->getParam($key, $source);
        if (!is_array($value)) {
            return $default_value;
        }
        $items = [];
        foreach ($value as $k => $val) {
            if (is_numeric($val)) {
                $val_int = (int) $val;
                $items[$k] = $val_int;
            }
        }

        return $items;
    }

    /**
     * @param $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function getArrayInt($key, array $default_value = [])
    {
        return $this->getParamArray($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param $key
     * @param array $default_value
     * @return array|mixed|null
     */
    public function postArrayInt($key, array $default_value = [])
    {
        return $this->getParamArray($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param $key
     * @param int $source
     * @param null $default_value
     * @return \DateTime|null
     */
    protected function getParamDate($key, $source = self::METHOD_GET, $default_value = null)
    {
        $value = $this->getParam($key, $source, $default_value);
        $value_int = $this->getParamInt($key, $source, $default_value);
        if (is_numeric($value_int)) {
            $date = new \DateTime();
            $date->setTimestamp($value_int);

            return $date;
        } elseif (is_string($value)) {
            try {
                return new \DateTime($value);
            } catch (\Exception $e) {
                return $default_value;
            }
        } else {
            return $default_value;
        }
    }

    /**
     * @param $key
     * @param null $default_value
     * @return \DateTime|null
     */
    public function getDate($key, $default_value = null)
    {
        return $this->getParamDate($key, self::METHOD_GET, $default_value);
    }

    /**
     * @param $key
     * @param null $default_value
     * @return \DateTime|null
     */
    public function postDate($key, $default_value = null)
    {
        return $this->getParamDate($key, self::METHOD_POST, $default_value);
    }

    /**
     * @param $key
     * @param int $source
     * @param null $from
     * @param null $to
     * @return array
     */
    protected function getParamDatePeriod($key, $source = self::METHOD_GET, $from = null, $to = null)
    {
        $return_array = ['from' => $from, 'to' => $to];
        $value = $this->getParam($key, $source);
        if (!$value || !is_string($value)) {
            return $return_array;
        }
        $array = explode('-', $value);
        if (count($array) != 2) {
            return $return_array;
        }
        try {
            $from = new \DateTime($array[0]);
            $return_array['from'] = $from;
        } catch (\Exception $e) {
        }
        try {
            $to = new \DateTime($array[1]);
            $to->setTime(23, 59);
            $return_array['to'] = $to;
        } catch (\Exception $e) {
        }

        return $return_array;
    }

    /**
     * @param $key
     * @param null $from
     * @param null $to
     * @return array
     */
    public function getDatePeriod($key, $from = null, $to = null)
    {
        return $this->getParamDatePeriod($key, self::METHOD_GET, $from, $to);
    }

    /**
     * @param $key
     * @param null $from
     * @param null $to
     * @return array
     */
    public function postDatePeriod($key, $from = null, $to = null)
    {
        return $this->getParamDatePeriod($key, self::METHOD_POST, $from, $to);
    }

    /**
     * @return bool|mixed
     */
    public function isPost(): mixed
    {
        return \Yii::$app->request->isPost;
    }

    /**
     * @return bool|mixed
     */
    public function isAjax(): mixed
    {
        return \Yii::$app->request->isAjax;
    }

    public function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
    }

    public function getUserFingerprint()
    {
        $request_params = array_map(function ($key) {
            return $key . '=' . $_SERVER[$key];
        }, [
            'REMOTE_ADDR',
            'REMOTE_HOST',
            'HTTP_ACCEPT',
            'HTTP_CONNECTION',
            'HTTP_USER_AGENT',
            'HTTP_VIA',
            'HTTP_FORWARDED',
            'HTTP_X_FORWARDED',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_PROXY_REMOTE_ADDR',
            'HTTP_PROXY_CONNECTION',
        ]);

        return implode('|', $request_params);
    }

    /**
     * @param int $int_ip
     * @return string
     */
    public function intToIp($int_ip)
    {
        if (!is_numeric($int_ip)) {
            return '0.0.0.0';
        }
        $value = (float) $int_ip;
        if (is_string($int_ip) && $int_ip !== (string) $value) {
            return '0.0.0.0';
        }
        return long2ip($int_ip);
    }

    /**
     * @return string
     */
    public function getCsrfToken()
    {
        return \Yii::$app->request->getCsrfToken();
    }
}
