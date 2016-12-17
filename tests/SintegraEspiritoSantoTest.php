<?php

use App\Services\SintegraEspiritoSanto;

class SintegraEspiritoSantoTest extends TestCase {

    /**
	 * @return void
	 */
	public function testConvertNameToJsonKey()
	{
        $SintegraEspiritoSanto = new SintegraEspiritoSanto();
        $this->assertEquals('a_string_valid', $SintegraEspiritoSanto->convertNameToJsonKey(' A string valid!'));
        $this->assertEquals('uma_string_com_acentuacao_valida', $SintegraEspiritoSanto->convertNameToJsonKey(' Uma string com Acentuação válida! '));
        $this->assertEquals('n_a', $SintegraEspiritoSanto->convertNameToJsonKey(''));
    }

    /**
     * @expectedException Exception
     */
	public function testGetInfoByCnpjWithWrongData()
	{
        $SintegraEspiritoSanto = new SintegraEspiritoSanto();
        $SintegraEspiritoSanto->getInfoByCnpj('31804115000244');
    }

    /**
     * @return void
     */
	public function testGetInfoByCnpj()
	{
        $SintegraEspiritoSanto = new SintegraEspiritoSanto();
        $json                  = $SintegraEspiritoSanto->getInfoByCnpj('31804115000243');

        $data = json_decode($json, true);
        $this->assertArrayHasKey('atualizacao_cadastro',          $data);
        $this->assertArrayHasKey('data_consulta',                 $data);
        $this->assertArrayHasKey('cnpj',                          $data);
        $this->assertArrayHasKey('inscricao_estadual',            $data);
        $this->assertArrayHasKey('razao_social',                  $data);
        $this->assertArrayHasKey('atividade_economica',           $data);
        $this->assertArrayHasKey('data_de_inicio_de_atividade',   $data);
        $this->assertArrayHasKey('situacao_cadastral_vigente',    $data);
        $this->assertArrayHasKey('data_desta_situacao_cadastral', $data);
        $this->assertArrayHasKey('regime_de_apuracao',            $data);
        $this->assertArrayHasKey('emitente_de_nfe_desde',         $data);
        $this->assertArrayHasKey('logradouro',                    $data);
        $this->assertArrayHasKey('numero',                        $data);
        $this->assertArrayHasKey('complemento',                   $data);
        $this->assertArrayHasKey('bairro',                        $data);
        $this->assertArrayHasKey('municipio',                     $data);
        $this->assertArrayHasKey('uf',                            $data);
        $this->assertArrayHasKey('cep',                           $data);
        $this->assertArrayHasKey('telefone',                      $data);
    }
}
