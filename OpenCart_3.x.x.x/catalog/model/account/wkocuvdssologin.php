<?php
class ModelAccountWkocuvdssologin extends Model {
	public function getApp($client_id, $redirect_url) {
		$sql = "SELECT * FROM " . DB_PREFIX . "uvdesksso WHERE status = 1 AND client_id = '" . $client_id . "' AND redirect_url = '" . $redirect_url . "'";

    $query = $this->db->query($sql);

    return $query->row;
	}

	public function getAppInfo($apptoken) {
		$sql = "SELECT * FROM " . DB_PREFIX . "uvdesksso WHERE status = 1 AND client_secret = (SELECT client_secret FROM " . DB_PREFIX . "uvdesksso_customer WHERE apptoken = '" . $apptoken . "')";

    $query = $this->db->query($sql);

    return $query->row;
	}

	public function addCustomerToken($apptoken, $client_secret) {

		if ($this->customer->getId()) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "uvdesksso_customer WHERE customer_id = " . $this->customer->getId());

	    $this->db->query("INSERT INTO " . DB_PREFIX . "uvdesksso_customer SET customer_id = '" . $this->customer->getId() . "', apptoken = '" . $apptoken . "', client_secret = '" . $client_secret . "'");
		}
	}

	public function getCustomerDetail($apptoken) {
		$sql = "SELECT CONCAT(c.firstname, ' ', c.lastname) AS name, c.email, uc.client_secret FROM " . DB_PREFIX . "uvdesksso_customer uc LEFT JOIN " . DB_PREFIX . "customer c ON (uc.customer_id = c.customer_id) WHERE uc.apptoken = '" . $apptoken . "'";

    $query = $this->db->query($sql);

    return $query->row;
	}

	public function deleteCustomerDetail($apptoken) {

		if ($apptoken) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "uvdesksso_customer WHERE apptoken = '" . $apptoken . "'");
		}
	}
}
