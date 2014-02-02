<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function last_query()
	{
		return $this->db->last_query();
	}

	public function count($table_name, $where = NULL)
	{
		if(null != $where)
		{
			$this->db->where($where);
		}
		return $this->db->count_all_results($table_name);
	}

	public function queryPaging($table_name, $limit, $offset, $where = NULL)
	{
		if($where != NULL)
		{
			$this->db->where($where);
		}
		$this->db->limit($limit, $offset);
		return $this->db->get($table_name);
	}

	function query($table_name, $where = NULL, $where_status = TRUE)
	{
		if($where != NULL)
		{
			$this->db->where($where, NULL, $where_status);
		}
		return $this->db->get($table_name);
	}

	function orQuery($table_name, $where = NULL)
	{
		if($where != NULL)
		{
			if(is_array($where))
			{
				$i = 0;
				foreach($where as $name => $value)
				{
					if($i++ == 0)
					{
						$this->db->where($name . "=" . $value);
					}
					else
					{
						$this->db->or_where($name . "=" . $value);
					}
				}
			}
			else
			{
				$this->db->where($where);
			}
		}
		return $this->db->get($table_name);
	}

	function update($table_name, $data = array(), $where = NULL) {
		if(count($data) == 0 || $where == NULL)
		{
			return FALSE;
		}
		else
		{
			$this->db->where($where);
			return $this->db->update($table_name, $data);
		}
	}

	function insert($table_name, $data = array())
	{
		if(count($data) == 0)
		{
			return FALSE;
		}
		else
		{
			return $this->db->insert($table_name, $data);
		}
	}

	function delete($table_name, $where)
	{
		if($where == NULL)
		{
			return FALSE;
		}
		else
		{
			$this->db->where($where);
			return $this->db->delete($table_name);
		}
	}

	function deleteWhereIn($table_name, $where_in)
	{
		if($where_in == NULL)
		{
			return FALSE;
		}
		else
		{
			foreach($where_in as $name => $array_value)
			{
				$this->db->where_in($name, $array_value);
			}
			return $this->db->delete($table_name);
		}
	}
}
// END MY_Model Class

/* End of file MY_Model.php */