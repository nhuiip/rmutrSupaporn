<?php
class Package_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_package');
    $this->db->join('tb_department', 'tb_department.dept_id = tb_package.dept_id', 'left');
    $this->db->join('tb_studentsex', 'tb_studentsex.sex_id = tb_package.sex_id', 'left');
    $this->db->join('tb_studenttype', 'tb_studenttype.stdtype_id = tb_package.stdtype_id', 'left');
    $this->db->join('tb_admin', 'tb_admin.ad_id = tb_package.pack_create', 'tb_admin.ad_id = tb_package.pack_lastedit', 'left');
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get();

    return $query->result_array();
  }

  public function listSex($data = array())
  {
    $this->db->select($data['fide']);
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get('tb_studentsex');

    return $query->result_array();
  }

  public function listStdtype($data = array())
  {
    $this->db->select($data['fide']);
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get('tb_studenttype');

    return $query->result_array();
  }

  public function insertData($data = array())
  {
    $this->db->insert("tb_package", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('pack_id' => $data['pack_id']));
    $this->db->update("tb_package", $data);
    return $data['pack_id'];
  }

  public function deleteData($data = array())
  {
    // delete form tb_package
    $this->db->where('pack_id', $data['pack_id']);
    $this->db->delete('tb_package');
  }

}
