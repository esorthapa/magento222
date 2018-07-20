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

namespace Javra\Viewcount\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CountRepositoryInterface
{


    /**
     * Save Count
     * @param \Javra\Viewcount\Api\Data\CountInterface $count
     * @return \Javra\Viewcount\Api\Data\CountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Javra\Viewcount\Api\Data\CountInterface $count
    );

    /**
     * Retrieve Count
     * @param string $countId
     * @return \Javra\Viewcount\Api\Data\CountInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($countId);

    /**
     * Retrieve Count matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Javra\Viewcount\Api\Data\CountSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Count
     * @param \Javra\Viewcount\Api\Data\CountInterface $count
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Javra\Viewcount\Api\Data\CountInterface $count
    );

    /**
     * Delete Count by ID
     * @param string $countId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($countId);
}
