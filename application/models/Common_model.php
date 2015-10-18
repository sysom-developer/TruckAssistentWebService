<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * 公共数据库操作
 * 方便二次扩展
 * @author yj
 *
 */

class Common_model extends CI_Model{
    
    public function __construct() {
		$this->load->database();
	}
	
	/**
	 * 
	 * 获取总数
	 * @param unknown_type $table_name
	 * @param unknown_type $where
	 */
	public function get_count($table_name = '', $where = array())
	{
	    $this->analyse_where($where);
	    
	    return $this->db->count_all_results($table_name);
	}
	
    /**
     * 
     * 获取结果集
     * @param unknown_type $table_name
     * @param unknown_type $where
     * @param unknown_type $limit
     * @param unknown_type $offset
     * @param unknown_type $order
     * @param unknown_type $order_by
     */
	public function get_data($table_name = '', $where = '', $limit = '', $offset = 0, $order = '', $order_by = 'ASC')
	{
		if (!empty($order))
		{
			$this->db->order_by($order, $order_by);
		}

		if ($limit)
		{
			$this->db->limit($limit, $offset);
		}

		$this->analyse_where($where);

		return $this->db->get($table_name);
	}

	/**
	 * 
	 * 插入数据
	 * @param unknown_type $table_name
	 * @param unknown_type $data
	 */
	public function insert($table_name, $data)
	{
		$this->db->insert($table_name, $data);
		
		return $this->db->insert_id();
	}
	
	/**
	 * 
	 * 更新数据
	 * @param unknown_type $table_name
	 * @param unknown_type $data
	 * @param unknown_type $where
	 */
	public function update($table_name = '', $data = array(), $where = array())
	{
	    $this->analyse_where($where);
		
    	$this->db->update($table_name, $data);
	    
	    return $this->db->affected_rows();
	}
	
	/**
	 * 
	 * 删除数据
	 * @param unknown_type $table_name
	 * @param unknown_type $where
	 */
	public function delete($table_name = '', $where = array())
	{
	    $this->analyse_where($where);
	    
	    return $this->db->delete($table_name);
	}
	
	/**
	 * 
	 * 参数where必须是一个数组
	 * 分析键值，如果是一个数组，则使用where_in，反之使用where	 
	 * @param unknown_type $where
	 */
	private function analyse_where($where)
	{
	    if (is_array($where))
		{
		    foreach ($where as $k => $v) {
		        if (is_array($v)) {
		            $this->db->where_in($k, $v);
		        } else {
		            $this->db->where($k, $v);
		        }
		    }
		}
	}
	
	/**
	 * 
	 * 开始事务
	 */
	public function trans_begin()
	{
	    $this->db->trans_begin();
	}
	
	/**
	 * 
	 * 提交事务
	 */
    public function trans_commit()
	{
	    $this->db->trans_commit();
	}

	/**
	 * 
	 * 回滚事务
	 */
	public function trans_rollback()
	{
		$this->db->trans_rollback();
	}

	/**
	 * 
	 * 事务错误信息
	 */
    public function trans_status()
	{
	    $this->db->trans_status();
	}
}