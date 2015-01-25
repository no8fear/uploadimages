<?php

class Gallery_model extends CI_MODEL{

	var $gallery_path;
	var $gallery_path_url;

	function Gallery_model(){
		$this->gallery_path = realpath(APPPATH. '../img');
		$this->gallery_path_url = base_url().'img/';
	}

	function do_upload(){

		$config = array('allowed_types' => 'jpg|jpeg|gif|png', 
						'upload_path' => $this->gallery_path, 
						'max_size' => 10
					);
		$this->load->library('upload', $config);
		$this->upload->do_upload();
		$image_data = $this->upload->data();

		$config = array('source_image' => $image_data['full_path'],
						'new_image' => $this->gallery_path . '/thumbs',
						'maintain_ration' => true,
						'width' => 150,
						'height' => 100
				);
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
	}

	function get_images(){
		$files = scandir($this->gallery_path);
		$files = array_diff($files, array('.', '..', 'thumbs'));

		$images = array();

		foreach($files as $file){
			$images []= array(
								'url' => $this->gallery_path_url . $file,
								'thumb_url' => $this->gallery_path_url . 'thumbs/' . $file
							);
		}

		return $images;
	}
}