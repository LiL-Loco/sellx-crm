<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pbxmanager_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_new_record($callParams)
    {
        // Prepare data for insertion
        $data = [
            'sourceuuid' => $callParams['uid'],
            'direction' => $callParams['direction'] == 'outgoing' ? 'outbound' : 'inbound',
            'callstatus' => $callParams['causeCode'] == '16' ? 'completed' : $callParams['causeText'],
            'starttime' => date('Y-m-d H:i:s', strtotime('-' . $callParams['duration'] . ' seconds')),
            'endtime' => date('Y-m-d H:i:s'),
            'totalduration' => $callParams['duration'],
            'customer' => $this->get_contact_id($callParams['number']),
            'customernumber' => $callParams['number'],
        ];

        $this->db->insert('pbx_calls', $data);
    }

    public function update_call_status($callParams, $status)
    {
        $this->db->where('sourceuuid', $callParams['uid']);
        $this->db->update('pbx_calls', ['callstatus' => $status]);
    }

    public function update_or_create_record($callParams)
    {
        $exists = $this->db->get_where('pbx_calls', ['sourceuuid' => $callParams['uid']])->row();

        if ($exists) {
            $this->update_call_status($callParams, $callParams['causeText']);
        } else {
            $this->create_new_record($callParams);
        }
    }

    private function get_contact_id($phone)
    {
        $this->db->select('id');
        $this->db->from('contacts');
        $this->db->where('phone', $phone);
        $contact = $this->db->get()->row();

        return $contact ? $contact->id : null;
    }
}
