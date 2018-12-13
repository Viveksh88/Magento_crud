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
        \Excellence\Crud\Model\TestFactory  $dataSend,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        
        
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
        if(isset($_POST['id'])){
           
            $u_id = $_POST['id'];
            $username = $_POST['uname'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email_ad'];
            $password = $_POST['pwd'];
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
            // $this->_redirect('crud/display/index');
            return $this->resultPageFactory->create();
        }   

        if(isset($_POST['send_data']))
        {

            $username = $_POST['username'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
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