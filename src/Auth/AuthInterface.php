<?php 
declare(strict_types=1);

namespace VRSFin\Auth;

interface AuthInterface
{
	public function login(array $credentials): bool;

	public function check(): bool;

	public function logout(): void;
}