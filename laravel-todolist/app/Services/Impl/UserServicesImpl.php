<?php

namespace App\Services\Impl;

use App\Services\UserService;

class UserServicesImpl implements UserService{

    private array $users = [
        "farhan" => "rahasia"
    ];

    public function login (string $user, string $password): bool{

        if(!isset($this->users[$user])){
            return false;
        }

        $confirmPassword = $this->users[$user];

        return $confirmPassword == $password;

    }

}