<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sm_contract_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
                [
                    'name'      => 'Contract ID',
                    'key'       => '{contract_id}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Subject',
                    'key'       => '{contract_subject}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Description',
                    'key'       => '{contract_description}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Date Start',
                    'key'       => '{contract_datestart}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Date End',
                    'key'       => '{contract_dateend}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Value',
                    'key'       => '{contract_contract_value}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Link',
                    'key'       => '{contract_link}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Contract Type',
                    'key'       => '{contract_type}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
                [
                    'name'      => 'Project name',
                    'key'       => '{project_name}',
                    'available' => [
                        'sm_contract',
                    ],
                ],
            ];
    }

    /**
     * Merge field for contracts
     * @param  mixed $contract_id contract id
     * @return array
     */
    public function format($contract_id)
    {
        $fields = [];
        $this->ci->db->select(db_prefix() . 'sm_contracts.id as id, subject, description, datestart, dateend, contract_value, hash, project_id, ' . db_prefix() . 'contracts_types.name as type_name');
        $this->ci->db->where('sm_contracts.id', $contract_id);
        $this->ci->db->join(db_prefix() . 'contracts_types', '' . db_prefix() . 'contracts_types.id = ' . db_prefix() . 'sm_contracts.contract_type', 'left');
        $contract = $this->ci->db->get(db_prefix() . 'sm_contracts')->row();

        if (!$contract) {
            return $fields;
        }

        $currency = get_base_currency();

        $fields['{contract_id}']             = $contract->id;
        $fields['{contract_subject}']        = $contract->subject;
        $fields['{contract_type}']           = $contract->type_name;
        $fields['{contract_description}']    = nl2br($contract->description);
        $fields['{contract_datestart}']      = _d($contract->datestart);
        $fields['{contract_dateend}']        = _d($contract->dateend);
        $fields['{contract_contract_value}'] = app_format_money($contract->contract_value, $currency);

        $fields['{contract_link}']      = site_url('contract/' . $contract->id . '/' . $contract->hash);
        $fields['{project_name}']       = get_project_name_by_id($contract->project_id);
        $fields['{contract_short_url}'] = get_contract_shortlink($contract);

        return hooks()->apply_filters('sm_contract_merge_fields', $fields, [
        'id'       => $contract_id,
        'contract' => $contract,
     ]);
    }
}
