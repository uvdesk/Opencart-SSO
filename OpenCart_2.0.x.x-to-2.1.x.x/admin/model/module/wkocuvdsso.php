<?php
class ModelModuleWkocuvdsso extends Model {
  public function createTable(){
    $this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."uvdesksso` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(1000) NOT NULL,
      `email` varchar(1000) NOT NULL,
      `redirect_url` varchar(1000) NOT NULL,
      `cancel_url` varchar(1000) NOT NULL,
      `client_id` varchar(1000) NOT NULL,
      `client_secret` varchar(1000) NOT NULL,
      `status` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;

    $this->db->query("CREATE TABLE IF NOT EXISTS `".DB_PREFIX ."uvdesksso_customer` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `customer_id` int(11) NOT NULL,
      `apptoken` varchar(1000) NOT NULL,
      `client_secret` varchar(1000) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1") ;
  }

  public function dropTable(){
    $this->db->query("DROP TABLE IF EXISTS " . DB_PREFIX . "uvdesksso;");
  }

  public function add($data){
    if (isset($this->request->get['id']) && $this->request->get['id']) {
      $this->db->query("UPDATE " . DB_PREFIX . "uvdesksso SET name = '" . $data['name'] . "', email = '" . $data['email'] . "', redirect_url = '" . $data['url'] . "', cancel_url = '" . $data['cancel_url'] . "', status = '" . $data['status'] . "' WHERE id = " . (int)$this->request->get['id']);
    } else {

      $client_id = mt_rand(100000000,999999999);

      $client_secret = bin2hex(openssl_random_pseudo_bytes(12));

      while ($this->db->query("SELECT * FROM " . DB_PREFIX . "uvdesksso WHERE client_id = '" . $client_id . "'")->num_rows) {
        $client_id = mt_rand(100000000,999999999);
      }

      while ($this->db->query("SELECT * FROM " . DB_PREFIX . "uvdesksso WHERE client_secret = '" . $client_secret . "'")->num_rows) {
        $client_secret = bin2hex(openssl_random_pseudo_bytes(12));
      }


      $this->db->query("INSERT INTO " . DB_PREFIX . "uvdesksso SET name = '" . $data['name'] . "', email = '" . $data['email'] . "', redirect_url = '" . $data['url'] . "', cancel_url = '" . $data['cancel_url'] . "', status = '" . $data['status'] . "', client_id = '" . $client_id . "', client_secret = '" . $client_secret . "'");
    }
  }

  public function getApp($id = 0){
    $sql = "SELECT * FROM " . DB_PREFIX . "uvdesksso WHERE 1";

    if ($id) {
      $sql .= " AND id = " . (int)$id;
    }

    $query = $this->db->query($sql);

    if ($id) {
      return $query->row;
    } else {
      return $query->rows;
    }
  }

  public function deleteApp($id = 0){
    if ($id) {
      $this->db->query("DELETE FROM " . DB_PREFIX . "uvdesksso WHERE id IN (" . $id . ")");
    }
  }
}
?>
