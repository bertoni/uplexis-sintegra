<?php

class ApiCnpjConsultTest extends TestCase {

    /**
	 * Test consult with invalid credentials
	 *
	 * @return void
	 */
	public function testConsultWithInvalidCredentials()
	{
		$response = $this->call('GET', '/api/consult/es/123', [], [], [], ['HTTP_user' => 'blabla', 'HTTP_key' => 'blabla']);

		$this->assertEquals(401, $response->getStatusCode());
	}

    /**
	 * Test consult with invalid cnpj
	 *
	 * @return void
	 */
	public function testConsultWithInvalidCnpj()
	{
		$response = $this->call('GET', '/api/consult/es/an-invalid-cnpj', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'uplexis123']);

		$this->assertEquals(400, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('cnpj informed is invalid', $content['message']);
	}

    /**
	 * Test consult with wrong cnpj
	 *
	 * @return void
	 */
	public function testConsultWithWrongCnpj()
	{
		$response = $this->call('GET', '/api/consult/es/31804115000244', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'uplexis123']);

		$this->assertEquals(400, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('CNPJ informed not found', $content['message']);
	}

    /**
	 * Test consult with valid cnpj
	 *
	 * @return void
	 */
	public function testConsultWithValidCnpj()
	{
		$response = $this->call('GET', '/api/consult/es/31804115000243', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'uplexis123']);

		$this->assertEquals(200, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('cnpj 31804115000243 consulted with success', $content['message']);
        $this->assertArrayHasKey('data', $content);
	}

}
