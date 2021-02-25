<?php

/**
 * @package		OpenCart
 * @author		delimce
 * @copyright	devElemento, Ltd. (https://www.delimce.com/)
 * @license		https://opensource.org/licenses/GPL-3.0
 * @link		https://www.delimce.com
 */
class OpCurrency
{

    private $curl;
    const URL_CURRENCY = "https://rekorbit.es/fiat/ve/ha/price";
    const CURRENCY_ID = 4;
    const CACHE_ID = "VES";
    const NIVEL_MIN = 360; // 6 Hours to equal db server to server time

    public function __construct($registry)
    {
        $this->db = $registry->get('db');
        $this->cache = $registry->get('cache');
        $this->curl = curl_init();
    }

    /**
     * getApiPrice
     *
     * @return double|false
     */
    protected function getApiPrice()
    {
        curl_setopt($this->curl, CURLOPT_URL, self::URL_CURRENCY);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 5);
        $result = curl_exec($this->curl);
        $httpcode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);
        return ($httpcode >= 200 && $httpcode < 300) ? json_decode($result, true) : false;
    }

    protected function minutesToAdd($lastTime)
    {
        $minutes_to_add = self::NIVEL_MIN + 30; // 30 minutes of cache
        $time = new DateTime($lastTime);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        return $time->format('Y-m-d H:i');
    }

    /**
     * isCacheValid
     *
     * @return bool
     */
    protected function isCacheValid()
    {
        $cache = $this->cache->get('currency');
        if (!$cache) {
            return false;
        }

        $max = $this->minutesToAdd($cache[self::CACHE_ID]["date_modified"]);
        if (time() - strtotime($max) < 0) {
            return true;
        }
        return false;
    }

    /**
     * setPrice
     *
     * @return void
     */
    public function setPrice()
    {
        if (!$this->isCacheValid()) {
            $price = $this->getApiPrice();
            if ($price) {
                #delete cache and save in db
                $query = "UPDATE oc_currency SET value = $price, date_modified = NOW() WHERE currency_id =" . self::CURRENCY_ID;
                $this->db->query($query);
                $this->cache->delete('currency');
            }
        }
    }
}
