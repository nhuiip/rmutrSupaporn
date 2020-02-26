<?php
class Faculty_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_faculty as fac');
    $this->db->join('tb_admin', 'tb_admin.ad_id = fac.fac_create', 'tb_admin.ad_id = fac.fac_lastedit', 'left');
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get();

    return $query->result_array();
  }

  public function insertData($data = array())
  {
    $this->db->insert("tb_faculty", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('fac_id' => $data['fac_id']));
    $this->db->update("tb_faculty", $data);
    return $data['fac_id'];
  }

  public function deleteData($data = array())
  {
    // delete form tb_faculty
    $this->db->where('fac_id', $data['fac_id']);
    $this->db->delete('tb_faculty');
  }

}
