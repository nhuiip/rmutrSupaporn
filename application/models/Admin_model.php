<?php
class Admin_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get('tb_admin');

    return $query->result_array();
  }

  public function insertData($data = array())
  {
    $this->db->insert("tb_admin", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('ad_id' => $data['ad_id']));
    $this->db->update("tb_admin", $data);
    return $data['ad_id'];
  }

  public function deleteData($data = array())
  {
    $this->db->where('ad_id', $data['ad_id']);
    $this->db->delete('tb_admin');
  }

}
