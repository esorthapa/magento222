<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 1/11/18
 * Time: 4:26 PM
 */

namespace Javra\Javraevents\Model\Post\Source;

use \Magento\Framework\Data\OptionSourceInterface;
use \Javra\Javraevents\Model\Post;

class IsType implements OptionSourceInterface
{
    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->post->getAvailableTypes();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}