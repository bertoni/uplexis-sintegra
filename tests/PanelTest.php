<?php

use App\Usuario;

class PanelTest extends TestCase {

    public static $Usuario;

    /**
	 * @return void
	 */
	public function testAddressLoginPage()
	{
        $response = $this->call('GET', '/login');
		$this->assertEquals(200, $response->getStatusCode());

        $this->assertEquals(1, preg_match('/Informe\ seu\ usuário\ e\ senha/', $response->getContent()));
        $this->assertEquals(1, preg_match('/\<input\ type\=\"text\"\ name\=\"username\"/', $response->getContent()));
        $this->assertEquals(1, preg_match('/\<input\ type\=\"password\"\ name\=\"password\"/', $response->getContent()));
        $this->assertEquals(1, preg_match('/\<button/', $response->getContent()));
	}

    /**
	 * @return void
	 */
	public function testLoginDoNotInformUser()
	{
        $response = $this->call('POST', '/autenticar');
		$this->assertEquals(302, $response->getStatusCode());
	}

    /**
	 * @return void
	 */
	public function testLoginDoNotInformPassword()
	{
        $response = $this->call('POST', '/autenticar', ['username' => 'blabla']);
		$this->assertEquals(302, $response->getStatusCode());
	}

    /**
	 * @return void
	 */
	public function testLoginInformingInvalidUser()
	{
        $response = $this->call('POST', '/autenticar', ['username' => 'blabla', 'password' => 'asdadas']);
		$this->assertEquals(302, $response->getStatusCode());
	}

    /**
	 * @return void
	 */
	public function testLoginInformingInvalidPassword()
	{
        $response = $this->call('POST', '/autenticar', ['username' => 'arnaldo', 'password' => 'asdadas']);
		$this->assertEquals(302, $response->getStatusCode());
	}

    /**
	 * @return void
	 */
	public function testLoginInformingValidData()
	{
        self::$Usuario = new Usuario;
        self::$Usuario->usuario = time();
        self::$Usuario->senha = time();
        self::$Usuario->save();

        $response = $this->call('POST', '/autenticar', ['username' => self::$Usuario->usuario, 'password' => self::$Usuario->senha]);
		$this->assertEquals(302, $response->getStatusCode());

        $response = $this->call('GET', '/minhas-consultas');
        $this->assertEquals(200, $response->getStatusCode());
	}

}
