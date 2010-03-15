<?php

class UploadController extends Zend_Rest_Controller
{
 
    private $_config = null;

    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $configArray = $bootstrap->getOptions();
        $this->_config = new Zend_Config($configArray);
    }

    // Handle GET and return a list of resources
    public function indexAction() 
    {
        $j = new JW_Cluster_UploadJobs($this->_config);
        $this->view->content = $j->getJobList();
    }

    // Handle GET and return a specific resource item
    public function getAction() 
    {
        $j = new JW_Cluster_UploadJobs($this->_config);
        $this->view->content = $j->getJob($this->_getParam('id'));
    }
    
    // Handle POST requests to create a new resource item
    public function postAction() {}

    // Handle PUT requests to update a specific resource item
    public function putAction() {}

    // Handle DELETE requests to delete a specific item
    public function deleteAction() {}
    
}