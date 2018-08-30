<?php

namespace App\Core;

class RecordSet extends \ArrayObject
{
    private $totalPages = 1;
    private $totalItems = 0;
    private $currentPage = 1;

    public function __construct($input = array(), int $flags = 0, string $iterator_class = "ArrayIterator")
    {
        parent::__construct($input, $flags, $iterator_class);
    }

    public function setData($array)
    {
        $this->exchangeArray($array);
    }

    public function getPaginatedData() : array
    {
        return [
            'items' => $this->getData(),
            'totalItems' => $this->getTotalItems(),
            'totalPages' => $this->getTotalPages(),
            'page' => $this->getCurrentPage()
        ];
    }

    public function getData()
    {
        $iterator = $this->getIterator();

        $data = [];

        while($iterator->valid())
        {
            $data[] = ($iterator->current())->getData();
            $iterator->next();
        }

        return $data;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @param int $totalPages
     */
    public function setTotalPages(int $totalPages)
    {
        $this->totalPages = $totalPages;
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    /**
     * @param int $totalItems
     */
    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }


}