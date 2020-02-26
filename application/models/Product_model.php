<?php
class Product_model extends CI_Model
{

  // Get data
  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_product');
    $this->db->join('tb_productstock', 'tb_productstock.stock_id = tb_product.stockid', 'left');
    $this->db->join('tb_typeproduct', 'tb_typeproduct.type_id = tb_product.type_id', 'left');
    $this->db->join('tb_admin', 'tb_admin.ad_id = tb_product.pdt_create', 'tb_admin.ad_id = tb_product.pdt_lastedit', 'left');
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    // qr data != in_array
    if(!empty($data['where_not_in'])){
			$this->db->where_not_in($data['where_not_in']['filde'], $data['where_not_in']['value']);
    }
    // qr data == in_array
    if(!empty($data['where_in'])){
			$this->db->where_in($data['where_in']['filde'],$data['where_in']['value']);
		}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get();

    return $query->result_array();
  }

  public function listType($data = array())
  {
    $this->db->select($data['fide']);
    if (!empty($data['where'])) {$this->db->where($data['where']);}
    if (!empty($data['orderby'])) { $this->db->order_by($data['orderby']);}
    if (!empty($data['limit'])) {$this->db->limit($data['limit'][0], $data['limit'][1]);}
    $query = $this->db->get('tb_typeproduct');

    return $query->result_array();
  }

  public function insertData($data = array())
  {
    $this->db->insert("tb_product", $data);
    return $this->db->insert_id();
  }

  public function updateData($data = array())
  {
    $this->db->where(array('pdt_id' => $data['pdt_id']));
    $this->db->update("tb_product", $data);
    return $data['pdt_id'];
  }

  public function deleteData($data = array())
  {
    $this->db->where('pdt_id', $data['pdt_id']);
    $this->db->delete('tb_product');
  }

}
