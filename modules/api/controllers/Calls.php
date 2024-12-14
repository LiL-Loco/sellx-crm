<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/** @noinspection PhpIncludeInspection */
require __DIR__ . '/REST_Controller.php';

class Calls extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
    }

    // Helper function to resolve staff ID from API token
    private function resolve_staff_id()
    {
        $token = $this->input->get_request_header('authtoken');

        if (!$token) {
            log_message('error', 'API token missing in request header.');
            return false;
        }

        // Check the token in the tbluser_api table
        $this->db->where('token', $token);
        $api_user = $this->db->get('tbluser_api')->row();

        if (!$api_user) {
            log_message('error', 'Invalid API token: ' . $token);
            return false;
        }

        // Match the user name with firstname in tblstaff
        $this->db->where('firstname', $api_user->user);
        $staff = $this->db->get('tblstaff')->row();

        if (!$staff) {
            log_message('error', 'No staff found for user: ' . $api_user->user);
            return false;
        }

        return $staff->staffid; // Use staff ID from tblstaff
    }

    // GET: Retrieve all call logs or a specific call log by ID
    public function data_get($id = '')
    {
        if ($id === '') {
            $result = $this->Api_model->get_all_call_logs();
        } else {
            $result = $this->Api_model->get_call_log($id);
        }

        if (isset($result['error'])) {
            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }

    // POST: Create a new call log
    public function data_post()
    {
        $data = $this->input->post();

        // Resolve staff ID from token
        $staff_id = $this->resolve_staff_id();
        if (!$staff_id) {
            $this->response(['error' => 'Invalid API token or staff mapping failed.'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data['staffid'] = $staff_id;

        $result = $this->Api_model->create_call_log($data);

        if (isset($result['error'])) {
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $this->response(['id' => $result], REST_Controller::HTTP_CREATED);
        }
    }

    // PUT: Update an existing call log by ID
    public function data_put($id = '')
    {
        if ($id === '') {
            $this->response(['error' => 'ID is required'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $data = json_decode($this->input->raw_input_stream, true);
        $result = $this->Api_model->update_call_log($id, $data);

        if (isset($result['error'])) {
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }

    // DELETE: Remove a call log by ID
    public function data_delete($id = '')
    {
        if ($id === '') {
            $this->response(['error' => 'ID is required'], REST_Controller::HTTP_BAD_REQUEST);
            return;
        }

        $result = $this->Api_model->delete_call_log($id);

        if (isset($result['error'])) {
            $this->response($result, REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }

    // GET: Search call logs based on criteria
    public function search_get()
    {
        $criteria = $this->input->get();
        $result = $this->Api_model->search_call_logs($criteria);

        if (isset($result['error'])) {
            $this->response($result, REST_Controller::HTTP_NOT_FOUND);
        } else {
            $this->response($result, REST_Controller::HTTP_OK);
        }
    }
}