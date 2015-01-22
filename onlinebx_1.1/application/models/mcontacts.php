<?php
class MContacts extends CI_Model
{
	/*
	function MContacts()
	{
		parent::Model();
	}
	*/


	function addContact()
	{
		$now = date("Y-m-d H:i:s");
		echo $this->input->post('name');
		//exit;
		$data = array( 
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'notes' => $this->input->post('notes'),
			'ipaddress' => $this->input->ip_address(),
			'stamp' => $now
		);

		$this->db->insert('contacts', $data);
	}

}

?>