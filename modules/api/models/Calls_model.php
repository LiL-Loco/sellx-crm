<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calls_model extends CI_Model {

    public function get_call_by_id($id) {
        return $this->db->get_where('calls', ['id' => $id])->row_array();
    }

    public function get_all_calls() {
        return $this->db->get('calls')->result_array();
    }

    public function log_call($data) {
        return $this->db->insert('calls', $data);
    }

    public function update_call($id, $data) {
        return $this->db->update('calls', $data, ['id' => $id]);
    }

    public function delete_call($id) {
        return $this->db->delete('calls', ['id' => $id]);
    }
}
