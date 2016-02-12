<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Doc extends CI_Controller {
	
	const CACHE = 60;
		
	public function index() 
	{ 
         echo "This is default function."; 
    }
	 	
	public function all() 
	{
		$this->output->cache(self::CACHE);
		$data['docs'] = $this->doc->get_list();
		$data['page_title'] = 'All Documents';
		$this->load->view('templates/header.php', $data);
		$this->load->view('doc_list', $data);	
	    $this->load->view('templates/footer.php', $data);
	}
	
	public function by_topic($topic_ids_str = NULL)
	{
		$this->output->cache(self::CACHE);
		$topic_ids = explode('-',$topic_ids_str);
		$data['docs'] = $this->doc->get_list_by_topic($topic_ids);
		$topics = array();
		foreach($topic_ids as $topic_id) {
			$topics[] = $this->topic->get_item($topic_id);
		}
		$data['topics'] = $topics;
		$data['page_title'] = 'Documents for Topic(s) ' . $topic_ids_str;
		$this->load->view('templates/header.php', $data);
		$this->load->view('doc_list', $data);	
	    $this->load->view('templates/footer.php', $data);		
	}
	
	public function by_entropy($hmin, $hmax = NULL)
	{
		$this->output->cache(self::CACHE);
		$data['docs'] = $this->doc->get_list_by_entropy($hmin,$hmax);
		$title_extra = " >= $hmin";
		if ($hmax) {
			$title_extra .= " and < $hmax";
		}
		$data['page_title'] = "Documents with Topic Entropy $title_extra";
		$this->load->view('templates/header.php', $data);
		$this->load->view('doc_list', $data);	
	    $this->load->view('templates/footer.php', $data);		
	}

	public function item($doc_id = NULL)
	{
		$this->output->cache(self::CACHE);
		$data['doc_id'] = $doc_id;
		$data['doc'] = $this->doc->get_item($doc_id);
		$data['page_title'] = "Doc $doc_id";
		#$data['topic_distro'] = $this->doc->get_topic_distro($doc_id);
		#$data['words'] = $this->doc->get_words($doc_id);
		$data['docs'] = $this->doc->get_docs($doc_id);
		$data['topics'] = $this->doc->get_topics($doc_id);
		$data['entropy'] = $this->doc->get_topic_entropy($doc_id);
		$this->load->view('templates/header.php', $data);
		$this->load->view('doc_item', $data);	
	    $this->load->view('templates/footer.php', $data);			
	}
  
}