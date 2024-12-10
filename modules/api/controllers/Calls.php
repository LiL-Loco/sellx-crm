<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// Laden von REST_Controller
require __DIR__ . '/REST_Controller.php';

class Calls extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Calls_model');
    }

    // GET: api/calls
    public function data_get($id = null) {
        if ($id) {
            $call = $this->Calls_model->get_call_by_id($id);
            if ($call) {
                $this->response($call, REST_Controller::HTTP_OK);
            } else {
                $this->response(['status' => false, 'message' => 'Call not found'], REST_Controller::HTTP_NOT_FOUND);
            }
        } else {
            $calls = $this->Calls_model->get_all_calls();
            $this->response($calls, REST_Controller::HTTP_OK);
        }
    }

    // POST: api/calls
    public function data_post() {
        $data = $this->input->post();
        if ($this->Calls_model->log_call($data)) {
            $this->response(['status' => true, 'message' => 'Call logged successfully'], REST_Controller::HTTP_CREATED);
        } else {
            $this->response(['status' => false, 'message' => 'Failed to log call'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // PUT: api/calls/123
    public function data_put($id = null) {
        $data = json_decode($this->input->raw_input_stream, true);
        if ($this->Calls_model->update_call($id, $data)) {
            $this->response(['status' => true, 'message' => 'Call updated successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Failed to update call'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // DELETE: api/calls/123
    public function data_delete($id = null) {
        if ($this->Calls_model->delete_call($id)) {
            $this->response(['status' => true, 'message' => 'Call deleted successfully'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Failed to delete call'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
