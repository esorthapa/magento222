<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/24/17
 * Time: 10:31 AM
 */

namespace Javra\Javraevents\Model\Post\Source;
use \Magento\Framework\Data\OptionSourceInterface;
use \Javra\Javraevents\Model\Post;

class IsActive implements OptionSourceInterface
{
    protected $post;


    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->post->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
