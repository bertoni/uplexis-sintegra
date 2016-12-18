<?php

namespace App\Services;

class SintegraEspiritoSanto extends Sintegra
{
    /**
	 * Create a new SintegraEspirito Santo instance
	 *
	 * @return void
	 */
	public function __construct()
	{
        $this->url = 'http://www.sintegra.es.gov.br/resultado.php';
	}

    /**
	 * Return information about a cnpj
     *
     * @param string $cnpj
	 *
     * @access public
	 * @return json
     * @throws Exception
	 */
	public function getInfoByCnpj($cnpj)
	{
        try {
            $source = $this->getExternalPage(
                array('num_cnpj' => $cnpj, 'botao' => 'Consultar'),
                'POST'
            );
        } catch (\Exception $e) {
            throw new \Exception('CNPJ informed not found');
        }

        return json_encode($this->parseHtml($source));
	}

    /**
	 * Return parsed json
     *
     * @param string $source
	 *
     * @access protected
	 * @return array
	 */
	protected function parseHtml($source)
	{
        $json = array();

        $source_encoded = mb_convert_encoding($source, 'UTF-8', 'ISO-8859-1');
        preg_match('/Cadastro\ atualizado\ até:\ (?P<date>.*)\</', $source_encoded, $matches);
        if (isset($matches['date'])) {
            $json['atualizacao_cadastro'] = trim($matches['date']);
        }
        preg_match('/Data\ da\ Consulta:\<\/b\>\&nbsp\;\<b\>(?P<date>.*)\<\/b\>/', $source_encoded, $matches);
        if (isset($matches['date'])) {
            $json['data_consulta'] = trim($matches['date']);
        }

        $html = new \DOMDocument();
        $html->preserveWhiteSpace = false;
        $html->loadHTML($source);

        $rows = $html->getElementsByTagName('tr');
        foreach ($rows as $row) {
            $cols = $row->getElementsByTagName('td');
            for ($i=0; $i<=$cols->length; $i+=2) {
                if (!is_null($cols->item($i))
                    && $cols->item($i)->hasAttribute('class')
                    && $cols->item($i)->getAttribute('class') == 'titulo'
                    && !is_null($cols->item($i+1))
                    && $cols->item($i+1)->hasAttribute('class')
                    && $cols->item($i+1)->getAttribute('class') == 'valor'
                ) {
                    $json[$this->convertNameToJsonKey($cols->item($i)->textContent)] = trim($cols->item($i+1)->textContent);
                }
            }
        }

        return $json;
    }
}
