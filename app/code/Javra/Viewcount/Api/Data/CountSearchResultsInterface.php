<?php
/**
 * This Module is generate number of count which like by user.
 * Copyright (C) 2017 www.javra.com 
 * 
 * This file is part of Javra/Viewcount.
 * 
 * Javra/Viewcount is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Javra\Viewcount\Api\Data;

interface CountSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get Count list.
     * @return \Javra\Viewcount\Api\Data\CountInterface[]
     */
    public function getItems();

    /**
     * Set Count list.
     * @param \Javra\Viewcount\Api\Data\CountInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
