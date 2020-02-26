<?php
class Student_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_student');
    $this->db->join('tb_department', 'tb_department.dept_id = tb_student.dept_id', 'left');
    $this->db->join('tb_studentsex', 'tb_studentsex.sex_id = tb_student.sex_id', 'left');
    $this->db->join('tb_studenttype', 'tb_studenttype.stdtype_id = tb_student.stdtype_id', 'left');
    $this->db->join('tb_admin', 'tb_admin.ad_id = tb_student.std_create', 'tb_admin.ad_id = tb_student.std_lastedit', 'left');
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
    $this->db->insert("tb_student", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('std_id' => $data['std_id']));
    $this->db->update("tb_student", $data);
    return $data['std_id'];
  }

  public function deleteData($data = array())
  {
    $this->db->where('std_id', $data['std_id']);
    $this->db->delete('tb_student');
  }
}