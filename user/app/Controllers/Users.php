<?php

namespace App\Controllers;

// require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Services/RabbitMQService.php';


use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Services\RabbitMQService;

class Users extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        // Get request body
        $data = $this->request->getJSON();

        // Validate data
        if (empty($data->email) || empty($data->firstName) || empty($data->lastName)) {
            return $this->failValidationErrors("Email, firstName, and lastName are required.");
        }

        // Save to database
        // $userModel = new UserModel();
        // $userModel->insert([
        //     'email' => $data->email,
        //     'firstName' => $data->firstName,
        //     'lastName' => $data->lastName
        // ]);



        // Publish message
        $rabbitMQService = new RabbitMQService();
        $rabbitMQService->publishMessage('data.submitted', json_encode([
            'email' => $data->email,
            'firstName' => $data->firstName,
            'lastName' => $data->lastName
        ]));

        $this->handleDataSubmission([
            'email' => $data->email,
            'firstName' => $data->firstName,
            'lastName' => $data->lastName
        ]);

        return $this->respondCreated(['message' => 'User created successfully']);
    }

    public function handleDataSubmission($data)
    {
        // Process the received message
        // $data = json_decode($msg->body, true);

        // Save the data to a log file
        $logData = date('Y-m-d H:i:s') . ': ' . json_encode($data) . PHP_EOL;
        file_put_contents(WRITEPATH . 'logs/data_submission.log', $logData, FILE_APPEND);
    }
}
