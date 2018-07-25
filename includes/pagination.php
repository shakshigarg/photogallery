<?php

class pagination{
	public $current_page;
	public $per_page;
	public $total_page;

    function __construct($page=1,$per_page=20,$total_count=0){
    	$this->current_page=(int)$page;
    	$this->per_page=(int)$per_page;
    	$this->total_page=(int)$total_count;
    }

    public function previous_page()
    {
    	return $this->current_page-1;
    }

    public function next_page()
    {
    	return $this->current_page+1;
    }

    public function has_previous_page()
    {
    	if($this->previous_page()>0)
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}

    }
  
    public function total_count_pages()
    {
    	return ceil($this->total_page/$this->per_page);
    }

    public function has_next_page()
    {
    	if($this->next_page()<=$this->total_count_pages())
    	{
    		return true;
    	}
    	else
    	{
    		return false;
    	}
    	
    }

    public function offset()
    {
    	return $this->per_page*$this->previous_page();
    }

}



?>