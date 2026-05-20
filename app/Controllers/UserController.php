<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function save()
    {   
        try {
            $userModel = new UserModel();

            $data = [
                "name" => $this->request->getPost('name'),
                "email" => $this->request->getPost('email'),
                "password" => password_hash(
                    $this->request->getPost('password'),
                    PASSWORD_DEFAULT
                ),
                "address" => $this->request->getPost('address'),
            ];

            $result = $userModel->insert($data);

            if (! $result) {
                return $this->response->setStatusCode(400)
                    ->setJSON([
                        "status" => false,
                        "message" => "Validation failed",
                        "errors" => $userModel->errors()
                    ]);
            }

            return $this->response->setJSON([
                "status" => true,
                "message" => "User created successfully",
                "id" => $result
            ]);

        } catch (\Throwable $e) {
            log_message('error', $e->getMessage());
            return $this->response->setStatusCode(500)
                ->setJSON([
                    "status" => false,
                    "message" => "Server errorrrrr"
                ]);
        }
    }
}