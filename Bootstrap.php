<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initRoutes() 
    {
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        $router->addRoute(
            'restToEncodeController',
            new Zend_Rest_Route($front, array(), array('default'=>array('encode')))
        );

        $router->addRoute(
            'restToUploadController',
            new Zend_Rest_Route($front, array(), array('default'=>array('upload')))
        );
        
    }

    protected function _initAmazonSqs()
    {
        $options = $this->getOptions();
        
        $sqs = new JW_Service_Amazon_Sqs(
            $options['amazon']['accessKeyId'],
            $options['amazon']['secretAccessKey']
        );
        
        return $sqs;
    }

    protected function _initAmazonS3()
    {
        $options = $this->getOptions();
        
        $sqs = new Zend_Service_Amazon_S3(
            $options['amazon']['accessKeyId'],
            $options['amazon']['secretAccessKey']
        );
        
        return $sqs;
    }
    
    protected function _initLog()
    {
        $options = $this->getOptions();
        
        $sqs = $this->getResource('AmazonSqs');
        $queue_name = $options['amazon']['sqs']['queues']['log'];

        $logger    = new Zend_Log();
        $writer    = new JW_Log_Writer_AmazonSqs($sqs, $queue_name);

        $logger->addWriter($writer);
        
        $logger->setEventItem('serverHostname', $_SERVER['SERVER_NAME']);

        Zend_Registry::set('logger', $logger);
        return $logger;
    }

}

