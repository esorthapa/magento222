<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/4/18
 * Time: 12:12 PM
 */

namespace Javra\Javraevents\Api;
use Javra\Javraevents\Api\Data\PostInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface PostRepositoryInterface
{


    /**
     * Save Post
     * @param PostInterface $job
     * @return PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        PostInterface $post
    );

    /**
     * Retrieve Post
     * @param string $postId
     * @return PostInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($postId);

    /**
     * Retrieve Post matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Post
     * @param PostInterface $post
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        PostInterface $post
    );

    /**
     * Delete Post by ID
     * @param string $postId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($postId);
}
