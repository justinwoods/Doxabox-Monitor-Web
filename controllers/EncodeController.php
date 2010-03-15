<?php

class EncodeController extends Zend_Rest_Controller
{
    private $_status	= null;
    private $_metadata	= null;
    private $_config	= null;

    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $configArray = $bootstrap->getOptions();
        $this->_config = new Zend_Config($configArray);
        
        $this->_metadata = JW_Video_Metadata::factory();
        $this->_status = new JW_Video_Job_Status_Ffmpeg;
    }

    // Handle GET and return a list of resources
    public function indexAction() 
    {
        $this->view->content =
            JW_Video_Job_Status::getJobList(
                $this->_config->video->encode->path->monitor
            );
    }

    // Handle GET and return a specific resource item
    public function getAction() 
    {
        $this->_status->setFilename(
            $this->_config->video->encode->path->monitor.'/'.$this->_getParam('id')
        );
        
        $this->view->content = $this->_status->getAll();
    }
    
    public function frameAction()
    {
        set_time_limit(0);
        $this->_status->setFilename(
             $this->_config->video->encode->path->monitor.'/'.$this->_getParam('id')
        );

        $this->view->content = $this->_metadata->getFrame($this->_status->current_frame);
    }

    // Handle POST requests to create a new resource item
    public function postAction() {}

    // Handle PUT requests to update a specific resource item
    public function putAction() {}

    // Handle DELETE requests to delete a specific item
    public function deleteAction() {}
    
}