<?php 

namespace VRSFin\Auth;

class Auth implements AuthInterface
{
	/**
	 * @var JasnyAuth
	 */
	private $jasnyAuth;

	public function __construct(JasnyAuth $jasnyAuth)
	{
		$this->jasnyAuth = $jasnyAuth;
	}

	public function login(array $credentials): bool
	{
		list('email' => $email, 'password' => $password) = $credentials;
		return $this->jasnyAuth->login($email, $password) !== null;
	}

	public function check(): bool
	{

	}

	public function logout(): void
	{

	}

	public function hashPassword(string $password): string
	{
		return $this->jasnyAuth->hashPassword($password);
	}
}