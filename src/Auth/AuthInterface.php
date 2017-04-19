<?php 
declare(strict_types=1);

namespace VRSFin\Auth;

use VRSFin\Models\UserInterface;

interface AuthInterface
{
	public function login(array $credentials): bool;

	public function check(): bool;

	public function logout(): void;

	public function hashPassword(string $password): string;

	public function user(): ?UserInterface;
}