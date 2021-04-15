<?php

namespace App\src\blogFram;

class Pagination
{    
    /**
     * @var int
     */
    private $limit;
    
    /**
     * @var int
     */
    private $page;
    
    /**
     * @var int
     */
    private $total;
    
    /**
     * @var int
     */
    private $pageNumber;
        
    /**
     * @var int
     */
    private $start;
    
    /**
     * construct pagination
     *
     * @param  int $limit
     * @param  int $page
     * @param  int $total
     * @return Pagination
     */
    public function __construct($limit, $page, $total)
    {
        $this->setLimit($limit);
        $this->setPage($page);
        $this->setTotal($total);
        $this->setPageNumber($this->getTotal(), $limit);
        $this->setStart($this->getPage(), $limit);
        return $this;
    }
    
    /**
     * get limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
    
    /**
     * get page
     *
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * get total
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * get page number
     *
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }
    
    /**
     * get start
     *
     * @return int
     */
    public function getStart()
    {
        return $this->start;
    }
    
    /**
     * set limit
     *
     * @param  int $limit
     * @return void
     */
    private function setLimit($limit)
    {
        $this->limit = $limit;
    }
    
    /**
     * set page
     *
     * @param  int $page
     * @return void
     */
    private function setPage($page)
    {
        if($page < 1) {
            $this->page = 1;
        } else {
            $this->page = $page;
        }
    }
    
    /**
     * set total
     *
     * @param  int $total
     * @return void
     */
    private function setTotal($total)
    {
        $this->total = $total;
    }
    
    /**
     * set page number
     *
     * @param  int $total
     * @param  int $limit
     * @return void
     */
    private function setPageNumber($total, $limit)
    {
        $this->pageNumber = ceil($total/$limit);
    }
    
    /**
     * set start
     *
     * @param  int $page
     * @param  int $limit
     * @return void
     */
    private function setStart($page, $limit)
    {
        $this->start = ($page - 1) * $limit;
    }
}