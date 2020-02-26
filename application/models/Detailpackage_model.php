<?php
class Detailpackage_model extends CI_Model
{
  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_packagedetail');
    $this->db->join('tb_package', 'tb_package.pack_id = tb_packagedetail.pack_id', 'left');
    $this->db->join('tb_product', 'tb_product.pdt_id = tb_packagedetail.pdt_id', 'left');
    $this->db->join('tb_admin', 'tb_admin.ad_id = tb_packagedetail.create_id', 'tb_admin.ad_id = tb_packagedetail.lastedit_id', 'left');
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
    $this->db->insert("tb_packagedetail", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('pack_id' => $data['pack_id'], 'pdt_id' => $data['pdt_id']));
    $this->db->update("tb_packagedetail", $data);
    // return $data['pack_id'];
  }

  public function deleteData($data = array())
  {
    // delete form tb_package
    $this->db->where(array('pack_id' => $data['pack_id'], 'pdt_id' => $data['pdt_id']));
    $this->db->delete('tb_packagedetail');
  }

}
