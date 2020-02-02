<?php
namespace App\Common;

use Illuminate\Http\Request;

class Page{
    public $request;
    private $_pageIndex;
    private $_pageSize;
    private $_offset;
    private $_total;
    private $_totalPage=0;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->_pageIndex = $request->input("pageIndex",1);
        $this->_pageSize = $request->input("pageSize",10);
        $this->_total = $request->input("total",0);
        $this->_offset = ($this->_pageIndex-1) * $this->_pageSize;
    }

    public function limit(){
        return $this->_pageSize;
    }

    public function offset($total=0){
        $this->setTotal($total);
        return $this->_offset;
    }

    public function pageIndex(){
        return $this->_pageIndex;
    }

    public function pageSize(){
        return $this->_pageSize;
    }

    public function total(){
        return $this->_total;
    }

    public function totalPage(){
        return $this->_totalPage;
    }

    public function info(){
        return [
            "page_index"=>$this->_pageIndex,
            "page_size"=>$this->_pageSize,
            "total"=>$this->_total,
            "total_page"=>$this->_totalPage
        ];
    }

    public function setTotal($total){
        $this->_total = $total;
        $this->_totalPage = ceil($total/$this->_pageSize);
    }


}
