<?php

class EstimateModel extends ci_model
{

    public function getAllClinets()
    {
       
        $query = "SELECT * FROM `estimate_clients` 
        LEFT JOIN estimate_quotation_type on estimate_clients.quotation_type_id=estimate_quotation_type.id
        left JOIN client_quotation_relation on estimate_clients.client_id=client_quotation_relation.client_id";

        $q = $this->db->query($query)->result_array();
        return $result = $this->db->affected_rows() ? $q : FALSE;
    }
}
