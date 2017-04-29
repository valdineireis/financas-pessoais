<?php 

namespace VRSFin\Models;

interface UserInterface
{
    public function getId(): int;
    public function getFullName(): string;
    public function getEmail(): string;
    public function getPassword(): string;
}
