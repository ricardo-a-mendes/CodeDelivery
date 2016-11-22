<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests\Admin\ClientUpdateRequest;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientController extends Controller
{
    var $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            $userId = Authorizer::getResourceOwnerId();

            //Client is a User with 'client' role
            $user = $this->userRepository
                ->skipPresenter(false)
                ->with('client')
                ->findWhere(['id' => $userId]);

            if (isset($user['data']) && count($user['data']) == 1)
                $user['data'] = $user['data'][0];

            return $user;
        }  catch (ModelNotFoundException $e) {
            return ['Client not found.'];
        }
    }
}
