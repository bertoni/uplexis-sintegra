<?php

class ApiCnpjConsultTest extends TestCase {

    /**
	 * Test consult with invalid credentials
	 *
	 * @return void
	 */
	public function testConsultWithInvalidCredentials()
	{
		$response = $this->call('GET', '/api/consult/123', [], [], [], ['HTTP_user' => 'blabla', 'HTTP_key' => 'blabla']);

		$this->assertEquals(401, $response->getStatusCode());
	}

    /**
	 * Test consult with invalid cnpj
	 *
	 * @return void
	 */
	public function testConsultWithInvalidCnpj()
	{
		$response = $this->call('GET', '/api/consult/an-invalid-cnpj', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'uplexis123']);

		$this->assertEquals(400, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('cnpj informed is invalid', $content['message']);
	}

    /**
	 * Test consult with valid cnpj
	 *
	 * @return void
	 */
	public function testConsultWithValidCnpj()
	{
		$response = $this->call('GET', '/api/consult/12123123000112', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'uplexis123']);

		$this->assertEquals(200, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('cnpj 12123123000112 consulted with success', $content['message']);
	}

}
