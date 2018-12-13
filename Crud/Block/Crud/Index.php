<?php
/**
 * Copyright © 2015 Excellence . All rights reserved.
 */
namespace Excellence\Crud\Block\Crud;
use Excellence\Crud\Block\BaseBlock;

class Index extends BaseBlock
{ 
	public function Receivedata()
	{
        
		$receivedata = $this->_collectiondata->create();
        $receivecollection = $receivedata->getCollection();
            return $receivecollection;
    }

}
