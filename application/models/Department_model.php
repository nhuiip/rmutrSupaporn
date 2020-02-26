<?php
class Department_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_department as dept');
    $this->db->join('tb_faculty', 'tb_faculty.fac_id = dept.fac_id', 'left');
    $this->db->join('tb_admin', 'tb_admin.ad_id = dept.dept_create', 'tb_admin.ad_id = dept.dept_lastedit', 'left');
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get();

    return $query->result_array();
  }

  public function insertData($data = array())
  {
    $this->db->insert("tb_department", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('dept_id' => $data['dept_id']));
    $this->db->update("tb_department", $data);
    return $data['dept_id'];
  }

  public function deleteData($data = array())
  {
    $this->db->where('dept_id', $data['dept_id']);
    $this->db->delete('tb_department');
  }

}
