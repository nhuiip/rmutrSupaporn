<?php
class Orders_model extends CI_Model
{

  public function listSetting()
  {
    $this->db->select('*');
    $this->db->where('set_id', 1);
    $query = $this->db->get('tb_settings');
    return $query->result_array();
  }

  public function listData($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_orders');
    $this->db->join('tb_student', 'tb_student.std_id = tb_orders.std_id', 'left');
    $this->db->join('tb_studenttype', 'tb_studenttype.stdtype_id = tb_student.stdtype_id', 'left');
    $this->db->join('tb_studentsex', 'tb_studentsex.sex_id = tb_student.sex_id', 'left');
    if (!empty($data['where'])) {
      $this->db->where($data['where']);
    }
    if (!empty($data['orderby'])) {
      $this->db->order_by($data['orderby']);
    }
    if (!empty($data['limit'])) {
      $this->db->limit($data['limit'][0], $data['limit'][1]);
    }
    $query = $this->db->get();

    return $query->result_array();
  }

  public function listDetail($data = array())
  {
    $this->db->select($data['fide']);
    $this->db->from('tb_ordersdetail');
    $this->db->join('tb_orders', 'tb_orders.orders_id = tb_ordersdetail.orders_id', 'left');
    $this->db->join('tb_product', 'tb_product.pdt_id = tb_ordersdetail.pdt_id', 'left');
    $this->db->join('tb_student', 'tb_student.std_id = tb_orders.std_id', 'left');
    $this->db->join('tb_studenttype', 'tb_studenttype.stdtype_id = tb_student.stdtype_id', 'left');
    $this->db->join('tb_studentsex', 'tb_studentsex.sex_id = tb_student.sex_id', 'left');

    if (!empty($data['where'])) {
      $this->db->where($data['where']);
    }
    if (!empty($data['orderby'])) {
      $this->db->order_by($data['orderby']);
    }
    if (!empty($data['limit'])) {
      $this->db->limit($data['limit'][0], $data['limit'][1]);
    }
    $query = $this->db->get();

    return $query->result_array();
  }

  // หน้าบ้าน
  public function insertOrder($data = array())
  {
    $this->db->insert("tb_orders", $data);
    return $this->db->insert_id();
  }

  public function insertDetail($data = array())
  {
    $this->db->insert("tb_ordersdetail", $data);
  }

  public function updateStock($data = array())
  {
    $this->db->where(array('stock_id' => $data['stock_id']));
    $this->db->update("tb_productstock", $data);
  }

  // หลังบ้าน
  public function updateData($data = array())
  {
    $this->db->where(array('orders_id' => $data['orders_id']));
    $this->db->update("tb_orders", $data);
    return $data['orders_id'];
  }

  public function deleteData($data = array())
  {
    // delete form tb_orders
    $this->db->where('orders_id', $data['orders_id']);
    $this->db->delete('tb_orders');
  }
}
