<?php
/**
 *
 * Copyright © 2015 Excellencecommerce. All rights reserved.
 */
namespace Excellence\Crud\Controller\Form;

class Index extends \Magento\Framework\App\Action\Action
{

	/**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $_dataSend;
    protected $_coreRegistry;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        
    
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Registry $coreRegistry,
        \Excellence\Crud\Model\TestFactory  $dataSend,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        
        $this->_coreRegistry = $coreRegistry;
        $this->_dataSend = $dataSend;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
    }
	
    /**
     * Flush cache storage
     *
     */
    public function execute()
    {

        // Deleting Data From Database......using Id..
        $delete_data = $this->getRequest()->getParams('id');
        if(isset($delete_data['delete_id'])){
            $id=$delete_data['delete_id'];
            $Deletedata = $this->_dataSend->create();
            $Deletedata->load($id);
            $d_deleted = $Deletedata->delete();
            if($d_deleted){
                $this->messageManager->addNotice( __('Record Deleted Successfully !') );
            }
            $this->_redirect('crud/display/index');
        }
        // Adding And Updating Data To database....
        $data_edit = $this->getRequest()->getPostValue();
        if(!empty($data_edit['id'])){
            
           
            $u_id = $data_edit['id'];
            $username = $data_edit['uname'];
            $fname = $data_edit['fname'];
            $lname = $data_edit['lname'];
            $email = $data_edit['email_ad'];
            $password = $data_edit['pwd'];
            $hash_pass = substr(md5($password),0,8);//password Encrypted upto 7 numbers...

            $model_update = $this->_dataSend->create()->load($u_id);
            $model_update->addData([
                "excellence_crud_id" =>$u_id,
                "username" => $username,
                "fristname" => $fname,
                "lastname" => $lname,
                "email" => $email,
                "password" => $hash_pass
                ]);
            $save_updated_Data = $model_update->save();
            if($save_updated_Data){
                $this->messageManager->addSuccess( __('Record Updated Successfully....!') );
            }
            return $this->resultPageFactory->create();
        }   

        $post = $this->getRequest()->getPostValue();
        if(isset($post['send_data']))
        {
            
            $username = $post['username'];
            $fname = $post['fname'];
            $lname = $post['lname'];
            $email = $post['email'];
            $password = $post['password'];
            $hash_pass = substr(md5($password),0,8);//password Encrypted upto 7 numbers...
            

            $model_insert = $this->_dataSend->create();
            $model_insert->addData([
                "username" => $username,
                "fristname" => $fname,
                "lastname" => $lname,
                "email" => $email,
                "password" => $hash_pass
                ]);
            $saveData = $model_insert->save();
            if($saveData){
                $this->messageManager->addSuccess( __('Insert Record Successfully !') );
            }
            $this->_redirect('crud/display/index');
            return $this->resultPageFactory->create();
            
        }
        
    }

}
?>