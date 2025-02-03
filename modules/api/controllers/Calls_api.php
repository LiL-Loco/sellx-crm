<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Calls extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->helper('url');
    }

    // GET: Retrieve all call logs or a specific log by ID
    public function index_get($id = null)
    {
        if ($id === null) {
            $result = $this->Api_model->get_all_call_logs();
        } else {
            $result = $this->Api_model->get_call_log($id);
        }

        if ($result) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['status' => true, 'data' => $result]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404)
                ->set_output(json_encode(['status' => false, 'error' => 'No data found']));
        }
    }

    // POST: Create a new call log
    public function create_post()
    {
        $data = json_decode($this->input->raw_input_stream, true);

        if ($data && $id = $this->Api_model->create_call_log($data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(201)
                ->set_output(json_encode(['status' => true, 'id' => $id]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['status' => false, 'error' => 'Failed to create call log']));
        }
    }

    // PUT: Update an existing call log
    public function update_put($id)
    {
        $data = json_decode($this->input->raw_input_stream, true);

        if ($this->Api_model->update_call_log($id, $data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['status' => true, 'message' => 'Call log updated']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['status' => false, 'error' => 'Failed to update call log']));
        }
    }

    // DELETE: Delete a call log
    public function delete_delete($id)
    {
        if ($this->Api_model->delete_call_log($id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['status' => true, 'message' => 'Call log deleted']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode(['status' => false, 'error' => 'Failed to delete call log']));
        }
    }
}
