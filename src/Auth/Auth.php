<?php 

namespace VRSFin\Auth;

use VRSFin\Auth\AuthInterface;
use VRSFin\Models\UserInterface;

class Auth implements AuthInterface
{
	/**
	 * @var JasnyAuth
	 */
	private $jasnyAuth;

	public function __construct(JasnyAuth $jasnyAuth)
	{
		$this->jasnyAuth = $jasnyAuth;
		$this->sessionStart();
	}

	public function login(array $credentials): bool
	{
		list('email' => $email, 'password' => $password) = $credentials;
		return $this->jasnyAuth->login($email, $password) !== null;
	}

	public function check(): bool
	{
		return $this->user() !== null;
	}

	public function logout(): void
	{

	}

	public function hashPassword(string $password): string
	{
		return $this->jasnyAuth->hashPassword($password);
	}

	public function user(): ?UserInterface
	{
		return $this->jasnyAuth->user();
	}

	protected function sessionStart() 
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	}
}