<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 12/6/17
 * Time: 11:59 AM
 */

namespace Javra\Javraevents\Api\Data;


use Magento\Framework\Api\SearchResultsInterface;
/**
 * Interface for cms page search results.
 * @api
 */
interface PostSearchResultsInterface extends SearchResultsInterface
{

    public function getItems();

    public function setItems(array $items);
}