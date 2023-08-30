<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
  public $title = 'Sistem Remunerasi Universitas Sriwijaya';

	public function __construct()
	{
		parent::__construct();
		// $this->load->library('lib_log');
	}

  /**
	 * Menampilkan view berdasarkan template layout yang telah dibuat
	 *
	 * @param Associative Array berupa data atau variabel yang akan diteruskan ke views
   * @param String letak folder template
	 **/
	public function template($data,$page='Page_2_8')
	{
		return $this->load->view($page, $data);
	}

  /**
	 * POST data
	 *
   * @param String nama parameter POST data
   * @return $_POST data
	 **/
	public function POST($name)
	{
		return $this->input->post($name);
	}

	public function GET($name)
	{
		return $this->input->get($name);
	}

  /**
	 * Menampilkan flash message
	 * Tipe-tipe peringatan yang tersedia adalah: info, danger, warning, success
   * @param String nama parameter POST data
   * @return $_POST data
	 **/
	public function flashmsg($msg, $type = 'success',$name='msg')
	{
		  return $this->session->set_flashdata($name, "swal({position: 'top-end',type: '".$type."',title: '".$msg."',showConfirmButton: false,timer: 3000});");
	}

  public function get_session($sess_key='')
  {
    return $this->session->userdata($sess_key);
  }

	public function upload($id, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = realpath(APPPATH . '../assets/img/' . $directory . '/');
			@unlink($upload_path . '/' . $id . '.jpg');
			$config = [
				'file_name' 		=> $id . '.jpg',
				'allowed_types'		=> 'jpg|png|bmp|jpeg',
				'upload_path'		=> $upload_path
			];
			$this->load->library('upload');
			$this->upload->initialize($config);
			return $this->upload->do_upload($tag_name);
		}
		return FALSE;
	}

	public function upload_file($name, $directory, $tag_name = 'userfile')
	{
		if ($_FILES[$tag_name])
		{
			$upload_path = realpath(APPPATH . '../assets/uploads/' . $directory . '/');
			@unlink($upload_path . '/' . $name);
			$config = [
				'file_name' 		=> $name,
				'allowed_types'		=> '*',
				'upload_path'		=> $upload_path
			];
			$this->load->library('upload');
			$this->upload->initialize($config);
			return $this->upload->do_upload($tag_name);
		}
		return FALSE;
	}

	public function dump($var)
	{
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	public function validate($conf)
	{
		$this->load->library('form_validation');
		foreach ($conf as $rule) {
			$this->form_validation->set_rules($rule,'required');
		}
		return $this->form_validation->run();
	}

	public function curl_get_request($url)
	{
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);

		// Will dump a beauty json :3
		$arr = json_decode($result);
		// $this->dump($arr);
		// exit;
		return $arr;
	}

	public function curl_post_request($url, $params)
	{
		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);

		$param = ''; $i = 0;
		foreach ($params as $key => $value)
		{
			$param .= $key . '=' . $value;
			if ($i < count($params) - 1)
			{
				$param .= '&';
				$i++;
			}
		}

		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

		// Execute
		$result=curl_exec($ch);

		// Closing
		curl_close($ch);

		// Will dump a beauty json :3
		$arr = json_decode($result);
		return $arr;
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
