<?php

namespace App\Services;

abstract class Sintegra
{
    /**
     * @var    string
     * @access protected
	 */
	protected $url;

    /**
	 * Return information about a cnpj
     *
     * @param string $cnpj
	 *
     * @access public
	 * @return json
     * @throws Exception
	 */
	abstract public function getInfoByCnpj($cnpj);

    /**
	 * Get response external page
     *
     * @param array  $data
     * @param string $method='GET'
     * @param integer $expected_code=200
	 *
     * @access protected
	 * @return string
     * @throws Exception
	 */
	protected function getExternalPage(array $data, $method = 'GET', $expected_code = 200)
	{
        $options = array(CURLOPT_URL => $this->url);
        switch ($method) {
        case 'GET':
            $options[CURLOPT_URL] .= (count($data) ? '?' . $this->_encodeData($data) : null);
            break;
        case 'POST':
            $options[CURLOPT_POSTFIELDS] = $this->_encodeData($data);
            $options[CURLOPT_POST]       = true;
            break;
        case 'PUT':
            $options[CURLOPT_POSTFIELDS]    = $this->_encodeData($data);
            $options[CURLOPT_CUSTOMREQUEST] = 'PUT';
            break;
        }
        $options += $this->_getOptions();


        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $ret  = curl_exec($ch);
        $err  = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($info['http_code'] != $expected_code) {
            if (strlen($ret)) {
                $erro = $ret;
            } else {
                $erro = 'Expected code returned with ' . $info['http_code'] ;
            }
            throw new \Exception($erro);
        }

        return $ret;
	}

    /**
     * Defines the minimum options of curl
     *
     * @access private
     * @return array
     */
    private function _getOptions()
    {
        return array(
            CURLOPT_HEADER         => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8'),
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_ENCODING       => "",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10
        );
    }

    /**
     * Transform the data to be sent
     *
     * @param array $data
     *
     * @access private
     * @return string
     */
    private function _encodeData(array $data)
    {
        if (!count($data)) {
            return '';
        }
        $data = http_build_query($data);
        return preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $data);
    }

    /**
     * Transform the a text in json key
     *
     * @param string $text
     *
     * @access protected
     * @return string
     */
    public function convertNameToJsonKey($text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '_', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '_', $text);
        $text = strtolower($text);
        $text = preg_replace('/^\_+/', '', $text);
        $text = preg_replace('/\_+$/', '', $text);
        if (empty($text)) {
            return 'n_a';
        }
        return $text;
    }
}
