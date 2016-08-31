<?php

class mainModel extends CI_Model{
	public function getAsideLinks()
	{
		$sql = "Select * from category";
		$result = $this->db->query($sql);
		$links = "";
		$base = base_url();
		foreach ($result->result() as $key => $value) {
			$links .= "<a href='$base'>"
		}
	}
}