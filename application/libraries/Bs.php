<?php

/**
 * 辅助类，获取一些基本信息
 */
class Bs
{
	/** 系统目录名称，对应CI里的目录结构 **/
	var $site_name = 'BSScoreSystem';
	/** 不带index.php的url **/
	var $base_url = '';
	/**  带index.php的url **/
	var $site_url = '';
	/** 系统名称 **/
	var $title = '本科毕业设计质量评价系统';
	/** 页面数据 **/
	var $data;
	/** CI的引用 **/
	var $CI;
	/**  错误数据的显示信息 **/
	const INVALID_DATA_TABLE = "<table style='width:100%;'><tr><td style='text-align:center;'><font color='red'>invalid_data!</font></td></tr></table>";
	/** 用户类型：管理员 **/
	const USER_ADMIN   = 0;
	/** 用户类型：学生 **/
	const USER_STUDENT = 1;
	/** 用户类型：教师 **/
	const USER_TEACHER = 2;

	function __construct()
	{
		$this->CI                   =& get_instance();
		//$this->CI->load->library(array("encrypt", "session"));
		//$this->CI->load->helper("url");
		$this->base_url             = base_url();
		$this->site_url				= site_url();
		
		$this->data['title']        = $this->title;
		$this->data['base_url']     = $this->base_url;
		$this->data['site_url']     = $this->site_url;
		$this->data['site_name']    = $this->site_name;
		$this->data['cssjscontent'] = $this->CI->load->view($this->getToolsUrl("common-css-js"), $this->data, true);
		$this->data['img_path']     = $this->base_url . "resources/img";
		$this->data['js_path']      = $this->base_url . "resources/js";
		$this->data['css_path']     = $this->base_url . "resources/css";

	}


	/**
	 * 生成分页
	 * @param  [type] $count    [数据总行数]
	 * @param  [type] $limit    [每页行数]
	 * @param  [type] $pageid   [页数]
	 * @param  [type] $order_by [排序字段]
	 * @param  [type] $callback [回调函数]
	 * @return [type]           [空]
	 */
	public function genPaging($paging_class_name, $count, $limit=10, $pageid=1, $order_by="", $callback="")
	{
		$data['paging_class_name']   = $paging_class_name;
		$data['orderBy']             = $order_by;
		$data['count']               = $count;
		$data['limit']               = $limit;
		$data['pageid']              = $pageid;
		$data['pageing_callback']    = $callback;
		$this->data['paging_data']   = $this->CI->load->view($this->getToolsUrl("paging_data"), $data, true);
		$this->data['paging_bar']    = $this->CI->load->view($this->getToolsUrl("paging_bar"), $data, true);
	}


	public function genTable($name_id, $table_head, $table_head_title, $table_data, $table_col_css)
	{
		$data['name_id']             = $name_id;
		$data['table_head']          = $table_head;
		$data['table_data']          = $table_data;
		$data['table_head_title']    = $table_head_title;
		$data['table_col_css']       = $table_col_css;
		$this->data['table_content'] = $this->CI->load->view($this->getToolsUrl("table"), $data, true);
	}

	/**
	 * 获取当前项目下的文件路径
	 * @param $uri 待转换的路径
	 * @return 转换后的的路径
	 */
	public function getSiteUrl($uri)
	{
		return $this->site_name . '/' . $uri;
	}

	/**
	 * 获取当前项目下的实用工具类文件路径
	 * @param $uri 待转换的路径
	 * @return 转换后的的路径
	 */
	public function getToolsUrl($uri)
	{
		return $this->site_name . '/tools/' . $uri;
	}

	/**
	 * 生成JSON字符串
	 * @param  integer $code [返回码]
	 * @param  string  $msg  [消息]
	 * @param  string  $data [数据]
	 * @return string        [JSON字符串]
	 */
	public function getJsonString($code=0, $msg="", $data="")
	{
		return "{'success':" . $code . ",'msg':'" . $msg . "','data':'" . $data . "'}";
	}

	public function checkUserLogin()
	{
		if($this->CI->session->userdata("username") === FALSE || $this->CI->session->userdata("username") == "")
		{
			$this->CI->load->view($this->getSiteUrl("login"), $this->data);
			return FALSE;
		}
		else 
		{
			return TRUE;
		}
	}
}

?>