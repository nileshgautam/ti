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
    
    public function getQuotationByClinets($clientid=null, $quotationid=null)
    {
       
        $query = "SELECT * FROM `client_quotation_relation`
        LEFT JOIN estimate_clients on client_quotation_relation.client_id=estimate_clients.client_id WHERE client_quotation_relation.client_id='$clientid' and client_quotation_relation.quation_id=$quotationid";

        $q = $this->db->query($query)->result_array();
        return $result = $this->db->affected_rows() ? $q : FALSE;
    }



}
