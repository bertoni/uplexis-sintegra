<?php

class ApiAuthenticateTest extends TestCase {

	/**
	 * Test without inform user
	 *
	 * @return void
	 */
	public function testConsumApiWithoutInformUserHeader()
	{
		$response = $this->call('GET', '/api/consult/es/123');

		$this->assertEquals(401, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('user not informed', $content['message']);
	}

    /**
     * Test without inform key
     *
     * @return void
     */
    public function testConsumApiWithoutInformKeyHeader()
    {
        $response = $this->call('GET', '/api/consult/es/123', [], [], [], ['HTTP_user' => 'blabla']);

        $this->assertEquals(401, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('key not informed', $content['message']);
    }

    /**
     * Test informing invalid user
     *
     * @return void
     */
    public function testConsumApiInformingInvalidUser()
    {
        $response = $this->call('GET', '/api/consult/es/123', [], [], [], ['HTTP_user' => 'blabla', 'HTTP_key' => 'blabla']);

        $this->assertEquals(401, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('user or key informed are invalid', $content['message']);
    }

    /**
     * Test informing invalid user
     *
     * @return void
     */
    public function testConsumApiInformingInvalidKey()
    {
        $response = $this->call('GET', '/api/consult/es/123', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'blabla']);

        $this->assertEquals(401, $response->getStatusCode());
        $content = (array)json_decode($response->getContent());
        $this->assertArrayHasKey('message', $content);
        $this->assertEquals('user or key informed are invalid', $content['message']);
    }

    /**
     * Test informing vali data
     *
     * @return void
     */
    public function testConsumApiInformingValidData()
    {
        $response = $this->call('GET', '/api/consult/es/123', [], [], [], ['HTTP_user' => 'arnaldo', 'HTTP_key' => 'uplexis123']);

        $this->assertNotEquals(401, $response->getStatusCode());
    }

}
