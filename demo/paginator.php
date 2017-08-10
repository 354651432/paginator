<?php

class paginator
{
    private $query = array();
    private $pageName = 'page';
    private $currentPage = 0;
    private $url;

    private $count = 0; // 总条数
    private $perPage = 20; // 每页条数
    private $pageCount = 0; // 总页数
    private $urlCount = 8; // 分页链接显示个数

    public function __construct($count, $perPage = 20, $pageName = 'page')
    {
        $this->count = $count;
        $this->perPage = $perPage;
        $this->pageCount = ceil($count / $perPage);
        $this->pageName = $pageName;
        $this->currentPage = $this->getCurrent();
        $this->url = $this->getBaseUrl();
    }

    private function getCurrent()
    {
        if (array_key_exists($this->pageName, $_GET)) {
            return intval($_GET[$this->pageName]);
        }
        return 0;
    }

    private function getBaseUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        return parse_url($url, PHP_URL_PATH);
    }

    public function getUrl($page)
    {
        $query = $this->query;
        $query[$this->pageName] = $page;
        return $this->url . "?" . http_build_query($query);
    }

    public function append($arr = array())
    {
        $this->query += $arr;
    }

    public function count()
    {
        return $this->count;
    }

    public function getResult()
    {
        $arr = array();
        list($begin, $end) = $this->getBeginEnd();
        for ($i = $begin; $i < $end; $i++) {
            $row = array(
                'url' => $this->getUrl($i),
                'name' => strval($i + 1),
                'class' => $i == $this->currentPage ? 'active' : '',
            );
            $arr[] = $row;
        }
        array_unshift($arr, $this->getPre());
        array_push($arr, $this->getNext());
        return $arr;
    }

    private function getBeginEnd()
    {
        $half = intval($this->urlCount / 2);
        $begin = $this->currentPage - $half;
        if ($begin < 0) {
            $begin = 0;
        }
        $end = $this->currentPage + $half + 1;
        // 当前页是第一页时，算出来的数值可能比链接数少
        if ($end < $this->urlCount) {
            $end = $this->urlCount;
        }
        // end 算出来 可能比总页数要多
        if ($end > $this->pageCount) {
            $end = $this->pageCount;
        }
        // 当页面出错时 只显示第一页
        if ($begin >= $end) {
            return array(0, 1);
        }
        return array($begin, $end);
    }

    public function getPre()
    {
        if ($this->currentPage <= 0) {
            return array(
                'url' => '#',
                'name' => '&laquo;',
                'class' => 'disabled',
            );
        }
        return array(
            'url' => $this->getUrl($this->currentPage - 1),
            'name' => '&laquo;',
            'class' => '',
        );
    }

    public function getNext()
    {
        if ($this->currentPage >= $this->pageCount) {
            return array(
                'url' => '#',
                'name' => '&raquo;',
                'class' => 'disabled',
            );
        }
        return array(
            'url' => $this->getUrl($this->currentPage + 1),
            'name' => '&raquo;',
            'class' => '',
        );
    }

    public function getLimit()
    {
        return array($this->perPage * $this->currentPage, $this->perPage);
    }
}