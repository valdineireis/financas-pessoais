<?php 

namespace VRSFin\Auth;

use Jasny\Auth\User;
use VRSFin\Repository\RepositoryInterface;

class JasnyAuth extends \Jasny\Auth
{
	use Sessions;

	private $repository;

	public function __construct(RepositoryInterface $repository)
	{
		$this->repository = $repository;
	}

	/**
     * Fetch a user by ID
     * 
     * @param int|string $id
     * @return User|null
     */
    public function fetchUserById($id)
    {
    	return $this->repository->find($id);
    }

    /**
     * Fetch a user by username
     * 
     * @param string $username
     * @return User|null
     */
    public function fetchUserByUsername($username)
    {
    	return $this->repository->findByField('email', $username)[0];
    }
}