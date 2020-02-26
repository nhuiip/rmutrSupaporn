<?php
class Stock_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_productstock');
    $this->db->join('tb_product', 'tb_product.pdt_id = tb_productstock.pdt_id', 'left');
    $this->db->join('tb_admin', 'tb_admin.ad_id = tb_productstock.stock_create', 'tb_admin.ad_id = tb_productstock.stock_lastedit', 'left');
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get();

    return $query->result_array();
  }

  public function insertData($data = array())
  {
    $this->db->insert("tb_productstock", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('stock_id' => $data['stock_id']));
    $this->db->update("tb_productstock", $data);
    return $data['stock_id'];
  }

  public function deleteData($data = array())
  {
    $this->db->where('stock_id', $data['stock_id']);
    $this->db->delete('tb_productstock');
  }

}
