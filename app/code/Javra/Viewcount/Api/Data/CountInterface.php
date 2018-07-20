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

interface CountInterface
{

    const COUNT_ID = 'count_id';
    const COUNT = 'Count';


    /**
     * Get count_id
     * @return string|null
     */
    public function getCountId();

    /**
     * Set count_id
     * @param string $countId
     * @return \Javra\Viewcount\Api\Data\CountInterface
     */
    public function setCountId($countId);

    /**
     * Get Count
     * @return string|null
     */
    public function getCount();

    /**
     * Set Count
     * @param string $count
     * @return \Javra\Viewcount\Api\Data\CountInterface
     */
    public function setCount($count);
}
