<?php

namespace App\Controllers;

use App\Controller;
use App\Models\User;
use Utils\Jwt;
use Utils\ResponseMessages\Response;
use Utils\UUID;

class UserController extends Controller
{
    private User $user;

    public function add(array $data)
    {
        $attrs = [
            'name'   => $data['name'],
            'secret' => UUID::v4(),
            'pass'   => bin2hex(random_bytes(32))
        ];
        $this->user = new User($attrs);
        $this->user->insert();
        return Response::getJson('S013-000', 200, ["user" => $attrs]);
    }

    public function login(array $data)
    {
        $jwt = new Jwt();

        $this->user = new User([
            "secret" => $data['secret'],
            "pass" => $data['pass']
        ]);

        $userId = $this->user->login();
        if (!$userId) return Response::getJson('E013-001', 401);

        return Response::getJson('S013-000', 200, $jwt->create(['userId' => $userId]));
    }
}
