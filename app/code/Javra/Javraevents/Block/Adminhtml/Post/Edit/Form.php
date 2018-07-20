<?php
/**
 * Created by PhpStorm.
 * User: ishwar
 * Date: 11/24/17
 * Time: 2:56 PM
 */

namespace Javra\Javraevents\Block\Adminhtml\Post\Edit;

use \Magento\Backend\Block\Widget\Form\Generic;
use \Magento\Backend\Block\Template\Context;
use \Magento\Framework\Registry;
use \Magento\Framework\Data\FormFactory;
use \Magento\Store\Model\System\Store;
use \Magento\Directory\Model\Config\Source\Country;

class Form extends Generic
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    protected $_country;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Store $systemStore,
        country $country,
        array $data = []
    )
    {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
        $this->_country = $country;
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('post_form');
        $this->setTitle(__('Post Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Javra\Javraevents\Model\Post $model */
        $model = $this->_coreRegistry->registry('blog_post');
        $countries = $this->_country->toOptionArray(false, 'US');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post', 'enctype' => 'multipart/form-data']]
        );

        $form->setHtmlIdPrefix('post_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getPostId()) {
            $fieldset->addField('post_id', 'hidden', ['name' => 'post_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            ['name' => 'title', 'label' => __('Post Title'), 'title' => __('Post Title'), 'required' => true]
        );

        $fieldset->addField(
            'url_key',
            'text',
            [
                'name' => 'url_key',
                'label' => __('URL Key'),
                'title' => __('URL Key'),
                'required' => true,
                'class' => 'validate-xml-identifier'
            ]
        );

        /*
         * this is field type fo the image
         */
        if ($model->getData('image') == "") {
            $fieldset->addField(
                'image',
                'image',
                [
                    'name' => 'image',
                    'label' => __('Image'),
                    'title' => __('Image'),
                    'class' => 'admin__control-image',
                    'note' => "Browse new image to replace old one.Allowed image type [ \"jpg\",\"jpeg\",\"gif\",\"png"
                ]
            );
        } else {
//            $path=$this->getBaseUrl().'pub/media/'.$model->getData('image');
//            $note = 'Browse new image to replace old one.Allowed image type [ "jpg","jpeg","gif","png"]<br/> <a href="'.$path.'" rel="lightbox" onclick="func_loadLightBox(this);return false;" title="'.$model->getTitle().'">
//                <img src="'.$path.'" style="width:100px;height:100px;"/></a><input type="hidden" name="image" value="'.$model->getData('image').'"> ';
            $fieldset->addField(
                'image',
                'image',
                [
                    'name' => 'image',
                    'label' => __('Image'),
                    'title' => __('Image'),
                    'width' => '50px',
                    'height' => '50px',
                    'class' => 'admin__control-image',
                    'note' => "Browse new image to replace old one.Allowed image type [ \"jpg\",\"jpeg\",\"gif\",\"png"
                ]
            );
        }

        /*
         * this is field type fo the New and Event Type
         */
        $fieldset->addField(
            'type',
            'select',
            [
                'label' => __('Type'),
                'title' => __('Type'),
                'name' => 'type',
                'required' => true,
                'options' => ['1' => __('News'), '0' => __('Events')]
            ]
        );

        $fieldset->addField(
            'created_by',
            'text',
            [
                'label' => __('Author'),
                'title' => __('Author'),
                'name' => 'created_by',
                'required' => true

            ]
        );

        $fieldset->addField(
            'location',
            'text',
            [
                'label' => __('Location'),
                'title' => __('Location'),
                'name' => 'location',
                'required' => true

            ]
        );

        $fieldset->addField(
            'country',
            'select',
            [
                'label' => __('Country'),
                'title' => __('country'),
                'name' => 'country',
                'required' => true,
                'values' => $countries

            ]
        );

        $fieldset->addField(
            'city',
            'text',
            [
                'label' => __('City'),
                'title' => __('city'),
                'name' => 'city',
                'required' => true

            ]
        );

        $fieldset->addField(
            'start_date',
            'date',
            [

                'name' => 'start_date',
                'label' => __('Start Time'),
                'title' => __('Start Time'),
                'date_format' => 'yyyy-MM-dd',
                'time_format' => 'h:m:s',
                'required' => true

            ]
        );

        $fieldset->addField(
            'end_date',
            'date',
            [

                'name' => 'end_date',
                'label' => __('End Time'),
                'title' => __('End Time'),
                'date_format' => 'yyyy-MM-dd',
                'time_format' => 'h:m:s'

            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'is_active',
                'required' => true,
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );
        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $fieldset->addField(
            'content',
            'editor',
            [
                'name' => 'content',
                'label' => __('Content'),
                'title' => __('Content'),
                'style' => 'height:36em',
                'required' => true
            ]
        );
        $fieldset->addField(
            'short_description',
            'text',
            [
                'name' => 'short_description',
                'label' => __('Short Description'),
                'title' => __('Short Description'),
                'style' => 'height:4em',
                'required' => true,
                'maxlength' => 50
            ]
        );
        $fieldset->addField('store_id', 'multiselect', array(
            'name' => 'store_id',
            'label' => 'Store View',
            'title' => 'Store View',
            'required' => true,
            'values' => $this->_systemStore->getStoreValuesForForm(false, true),
        ));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
