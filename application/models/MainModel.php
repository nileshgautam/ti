<?php

class MainModel extends ci_model
{
	public function getNewIDorNo($tableName, $prefix = "", $pad_length = 3)
	{
		$id = 0;
		$row = $this->db->query("SELECT max(id) as maxid  FROM " . $tableName)->row();

		if ($row) {
			$id = $row->maxid;
		}
		$id++;

		$Id = strtoupper($prefix . date('y') . date('m') . date('d') . str_pad($id, $pad_length, '0', STR_PAD_LEFT));

		return $Id; // $maxid==NULL?1:$maxid+1;
	}

	public function selectColumnFromTable($tableName = null, $columnName = null)
	{
		$this->db->select($columnName); // ('a,b,c')
		$result = $this->db->get($tableName)->result_array();
		return $this->db->affected_rows() ? $result : FALSE;
	}

	public function selectColumnFromTableWhere($tableName = null, $columnName = null, $condition)
	{
		$this->db->select($columnName); // ('a,b,c')
		$result = $this->db->get_where($tableName, $condition)->result_array();
		return $this->db->affected_rows() ? $result : FALSE;
	}



	public function selectAllFromTable($tableName = null)
	{
		$imageUrl = base_url() . "assets/noticeImage/";
		if ($tableName == "noticeboard") {
			$query = $this->db->query("SELECT *,CONCAT('$imageUrl',noticeImage) as noticeImage FROM $tableName");
		} else {
			$query = $this->db->get($tableName);
		}
		$result = $query->result_array();
		return $this->db->affected_rows() ? $result : FALSE;
	}

	public function deleteAllTableData()
	{
		$query = $this->db->query("SHOW TABLES");
		$name = $this->db->database;
		foreach ($query->result_array() as $row) {
			if ($row['Tables_in_' . $name] == "erp_admin" || $row['Tables_in_' . $name] == "city" || $row['Tables_in_' . $name] == "country_t" || $row['Tables_in_' . $name] == "gender" || $row['Tables_in_' . $name] == "tbl_cast" || $row['Tables_in_' . $name] == "tbl_religion" || $row['Tables_in_' . $name] == "tbl_occupation" || $row['Tables_in_' . $name] == "leave") {
			} else {
				$table = $row['Tables_in_' . $name];
				$this->db->query("TRUNCATE " . $table);
				$this->db->query("ALTER TABLE " . $table . " AUTO_INCREMENT = 1");
			}
		}
		return TRUE;
	}

	public function selectAllFromWhere($tableName = null, $condition = null, $getColumn = null)
	{
		$query = $this->db->get_where($tableName, $condition)->result_array();

		if ($getColumn == null) {
			return $this->db->affected_rows() ? $query : FALSE;
		} else {
			return $this->db->affected_rows() ? $query[0][$getColumn] : FALSE;
		}
	}

	public function insertInto($tableName = null, $data = null)
	{
		$this->db->insert($tableName, $data);
		return $this->db->affected_rows() ? TRUE : FALSE;
	}

	public function getinsertedData($tableName = null, $data = null)
	{
		$this->db->insert($tableName, $data);
		$id = $this->db->insert_id();
		$q = $this->db->get_where($tableName, array('id' => $id))->result_array();
		return $q;
	}

	public function updateWhere($tableName = null, $data = null, $condition = null)
	{
		$this->db->trans_start();
		$this->db->where($condition);
		$this->db->update($tableName, $data);
		$this->db->trans_complete();

		return $this->db->trans_status();
		//	$this->db->where($condition);
		//	$this->db->update($tableName, $data); 
		//	return $this->db->affected_rows()?TRUE:FALSE;
	}

	public function selectAllFromTableWhere($tableName = null, $condition = null)
	{
		$result = $this->db->get_where($tableName, $condition)->result_array();
		return $this->db->affected_rows() ? $result : FALSE;
	}

	public function selectAllFromTableOrderBy($tableName = null, $columnName = null, $orderBy = null, $condition = '')
	{
		$this->db->order_by($columnName, $orderBy);
		if ($condition != '') {
			$query = $this->db->get_where($tableName, $condition)->result_array();
			return $this->db->affected_rows() ? $query : FALSE;
		} else {
			$query = $this->db->get($tableName)->result_array();
			return $this->db->affected_rows() ? $query : FALSE;
		}
	}

	public function selectAllFromTableLike($tableName = null, $likeCondition = null, $condition = [])
	{
		$count = count($condition);
		if ($count == 1) {
			foreach ($condition as $key => $content) {
				$this->db->like($key, $content, $likeCondition);
			}
			$q = $this->db->get($tableName)->result_array();
		} else {
			$this->db->like($condition);
			$q = $this->db->get($tableName)->result_array();
		}

		if ($this->db->affected_rows()) {
			return $q;
		} else {
			return false;
		}
	}

	public function selectAllFromLikeOR($tableName = null, $likeCondition = null, $condition = [])
	{
		$sql = "SELECT * FROM " . $tableName;
		$i = 0;
		foreach ($condition as $key => $data) {
			if ($likeCondition == 'before') {
				if ($i == 0) {
					$sql .= " WHERE `$key` LIKE '%$data'";
				} else {
					$sql .= " OR `$key` LIKE '%$data'";
				}
				$i++;
			} elseif ($likeCondition == 'after') {
				if ($i == 0) {
					$sql .= " WHERE `$key` LIKE '$data%'";
				} else {
					$sql .= " OR `$key` LIKE '$data%'";
				}
				$i++;
			} elseif ($likeCondition == 'both') {
				if ($i == 0) {
					$sql .= " WHERE `$key` LIKE '%$data%'";
				} else {
					$sql .= " OR `$key` LIKE '%$data%'";
				}
				$i++;
			}
		}
		$q = $this->db->query($sql)->result_array();

		if ($this->db->affected_rows()) {
			return $q;
		} else {
			return false;
		}
	}

	public function deleteFromTable($tableName = null, $condition = null)
	{
		$this->db->delete($tableName, $condition);
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function selectAllFromTableGroupBy($tableName = null, $condition = [], $groupBy = null)
	{
		$this->db->group_by($groupBy);
		$this->db->where($condition);
		$q = $this->db->get($tableName)->result_array();

		if ($this->db->affected_rows()) {
			return $q;
		} else {
			return false;
		}
	}

	public function selectAllFromTableFullJoin($firstTable, $secondTable, $conditionColumn, $conditionValue, $firstTableColumn, $secondTableColumn)
	{
		$this->db->select('*');
		$this->db->from($firstTable);
		$this->db->join($secondTable, $firstTable . "." . $firstTableColumn . "=" . $secondTable . "." . $secondTableColumn);

		$this->db->where($firstTable . "." . $conditionColumn, $conditionValue);

		$result = $this->db->get()->result_array();
		if ($this->db->affected_rows()) {
			return $result;
		} else {
			return false;
		}
	}

	public function deleteFromTableWhere($tableName = null, $condition = null)
	{
		$this->db->delete($tableName, $condition);
		return $this->db->affected_rows() ? true : false;
	}

	public function truncateTable($tableName = null)
	{
		$this->db->query("TRUNCATE " . $tableName);
		$this->db->query("ALTER TABLE " . $tableName . " AUTO_INCREMENT = 1");
		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function getservicesWithPackage($id = null)
	{
		$this->db->select('*');
		$this->db->from('services s');
		$this->db->join('service_packages SP', 'SP.service_id = s.serviceId', 'left');
		$this->db->where('s.serviceId', $id);
		$result = $this->db->get()->result_array();
		if ($this->db->affected_rows()) {
			return $result;
		} else {
			return false;
		}
	}

	public function getAllServices($id = null)
	{
		$this->db->select('*');
		$this->db->from('services s');
		$this->db->join('service_packages SP', 'SP.service_id = s.serviceId', 'left');
		$result = $this->db->get()->result_array();
		if ($this->db->affected_rows()) {
			return $result;
		} else {
			return false;
		}
	}

	public function getUserServices($id = null, $userId = null)
	{
		$this->db->select('*');
		$this->db->from('services s');
		$this->db->join('service_packages SP', 'SP.service_id = s.serviceId', 'left');
		$this->db->join('user_services US', 'US.service_id = s.serviceId', 'left');
		$this->db->where('s.serviceId', $id);
		$this->db->where('US.user_id', $userId);
		$result = $this->db->get()->result_array();
		if ($this->db->affected_rows()) {
			return $result;
		} else {
			return false;
		}
	}

	public function getPaymentsWithServices($userId = null)
	{
		$this->db->select('*');
		$this->db->from('payments p');
		$this->db->join('services s', 'p.serviceId = s.serviceId', 'left');
		$this->db->where('p.user_id', $userId);
		$result = $this->db->get()->result_array();
		if ($this->db->affected_rows()) {
			return $result;
		} else {
			return false;
		}
	}


	// public function selectColumnFromTable($tableName=null,$columnName=null)
	// {
    //     $this->db->select($columnName); // ('a,b,c')
    //     $result = $this->db->get($tableName)->result_array();
    //     return $this->db->affected_rows()?$result:FALSE;
	// }

	// public function selectColumnFromTableWhere($tableName=null,$columnName=null,$condition)
	// {
 	// 	$this->db->select($columnName); // ('a,b,c')
  	// 	$result = $this->db->get_where($tableName,$condition)->result_array();
   	// 	return $this->db->affected_rows()?$result:FALSE;
	// }


	
	// public function selectAllFromTable($tableName=null)
	// {
	// 	$imageUrl = base_url()."assets/noticeImage/";
	// 	if($tableName=="noticeboard"){
	// 		$query = $this->db->query("SELECT *,CONCAT('$imageUrl',noticeImage) as noticeImage FROM $tableName");
	// 	}
	// 	else{
	// 		$query = $this->db->get($tableName);
	// 	}
	// 	$result=$query->result_array();
	// 	return $this->db->affected_rows()?$result:FALSE;
	// }

	// public function deleteAllTableData()
	// {
	// 	$query = $this->db->query("SHOW TABLES");
    //     $name = $this->db->database;
    //     foreach ($query->result_array() as $row)
    //     {
    // 	   if($row['Tables_in_' . $name]=="erp_admin" || $row['Tables_in_' . $name]=="city" || $row['Tables_in_' . $name]=="country_t" || $row['Tables_in_' . $name]=="gender" || $row['Tables_in_' . $name]=="tbl_cast" || $row['Tables_in_' . $name]=="tbl_religion" || $row['Tables_in_' . $name]=="tbl_occupation" || $row['Tables_in_' . $name]=="leave")
    // 	   {
                 
    // 	   }
    // 	   else
    // 	   {
    // 	           $table = $row['Tables_in_' . $name];
    // 	           $this->db->query("TRUNCATE " . $table);
    //             $this->db->query("ALTER TABLE ".$table." AUTO_INCREMENT = 1");
    // 	   }        
    //     }
    // return TRUE;
	// }

	// public function selectAllFromWhere($tableName=null,$condition=null,$getColumn=null)
	// {
	// 	$query = $this->db->get_where($tableName,$condition)->result_array();
	// 	if($getColumn==null)
	// 	{
	// 	             return $this->db->affected_rows()?$query:FALSE;
	// 	 }
	// 	 else
	// 	 {
	// 	 	return $this->db->affected_rows()?$query[0][$getColumn]:FALSE;
	// 	 }
	// }

	// public function insertInto($tableName=null,$data=null)
	// {
	// 	$this->db->insert($tableName,$data);
	// 	return $this->db->affected_rows()?TRUE:FALSE;
	// }

	// public function updateWhere($tableName=null,$data=null,$condition=null)
	// {
	// 	$this->db->where($condition);
	// 	$this->db->update($tableName, $data); 
	// 	return $this->db->affected_rows()?TRUE:FALSE;
	// }

	// public function selectAllFromTableWhere($tableName=null,$condition=null,$getColumn=null)
	// {
	// 	$result = $this->db->get_where($tableName,$condition)->result_array();
    //     return $this->db->affected_rows()?$result:FALSE;
	// }

	// public function selectAllFromTableOrderBy($tableName=null,$columnName=null,$orderBy=null,$condition)
	// {
	// 	$this->db->order_by($columnName,$orderBy);
	// 	if($condition!='')
	// 	{
	// 		$query = $this->db->get_where($tableName,$condition)->result_array();
    //         return $this->db->affected_rows()?$query:FALSE;
	// 	}
	// 	else
	// 	{
	// 		$query = $this->db->get($tableName)->result_array();
    //         return $this->db->affected_rows()?$query:FALSE;
	// 	}
	// }

	// public function selectAllFromTableLike($tableName=null,$likeCondition=null,$condition=[])
	// {
	// 	$count = count($condition);
	// 	if($count==1)
	// 	{
	// 		foreach($condition as $key => $content)
	// 		{
	// 			$this->db->like($key,$content,$likeCondition);
	// 		}			
	// 		$q = $this->db->get($tableName)->result_array();
	// 	}
	// 	else
	// 	{
	// 		$this->db->like($condition);
	// 		$q = $this->db->get($tableName)->result_array();
	// 	}
		
	// 	if($this->db->affected_rows())
	// 	{
	// 		return $q;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// public function selectAllFromLikeOR($tableName=null,$likeCondition=null,$condition=[])
	// {
	// 	$sql = "SELECT * FROM ".$tableName;
	// 	$i=0;
	// 	foreach($condition as $key => $data)
	// 	{
	// 		if($likeCondition=='before')
	// 		{
	// 			if($i==0)
	// 			{
	// 				$sql .= " WHERE `$key` LIKE '%$data'";
	// 			}
	// 			else
	// 			{
	// 				$sql .= " OR `$key` LIKE '%$data'";
	// 			}
	// 			$i++;
	// 		}
	// 		elseif($likeCondition=='after')
	// 		{
	// 			if($i==0)
	// 			{
	// 				$sql .= " WHERE `$key` LIKE '$data%'";
	// 			}
	// 			else
	// 			{
	// 				$sql .= " OR `$key` LIKE '$data%'";
	// 			}
	// 			$i++;
	// 		}
	// 		elseif($likeCondition=='both')
	// 		{
	// 			if($i==0)
	// 			{
	// 				$sql .= " WHERE `$key` LIKE '%$data%'";
	// 			}
	// 			else
	// 			{
	// 				$sql .= " OR `$key` LIKE '%$data%'";
	// 			}
	// 			$i++;
	// 		}
			
	// 	}
	// 	$q = $this->db->query($sql)->result_array();

	// 	if($this->db->affected_rows())
	// 	{
	// 		return $q;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}				
	// }

	// public function deleteFromTable($tableName=null,$condition=null)
	// {
	// 	$this->db->delete($tableName,$condition);
	// 	if($this->db->affected_rows())
	// 	{
	// 		return true;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// public function selectAllFromTableGroupBy($tableName=null,$condition=[],$groupBy=null)
	// {
	// 	$this->db->group_by($groupBy);
	// 	$this->db->where($condition);
	// 	$q = $this->db->get($tableName)->result_array();

	// 	if($this->db->affected_rows())
	// 	{
	// 		return $q;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// public function selectAllFromTableFullJoin($firstTable,$secondTable,$conditionColumn,$conditionValue,$firstTableColumn,$secondTableColumn)
	// {
	// 	$this->db->select('*');
	// 	$this->db->from($firstTable);		
	// 	$this->db->join($secondTable, $firstTable.".".$firstTableColumn ."=". $secondTable.".".$secondTableColumn);
		
	// 	$this->db->where($firstTable.".".$conditionColumn,$conditionValue);

	// 	$result = $this->db->get()->result_array();
	// 	if($this->db->affected_rows())
	// 	{
	// 		return $result;
	// 	}
	// 	else
	// 	{
	// 		return false;
	// 	}
	// }

	// public function deleteFromTableWhere($tableName=null,$condition=null){
	// 	$this->db->delete($tableName,$condition);
	// 	return $this->db->affected_rows()?true:false; 
	// }

	public function selectQuery($query=null)
	{
		$q = $this->db->query($query)->result_array();
		return $this->db->affected_rows() ? $q : FALSE;
	}
}
