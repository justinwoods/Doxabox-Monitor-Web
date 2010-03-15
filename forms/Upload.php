<?

class Application_Form_Upload extends Zend_Form 
{

    public function init()
    {
        $this->setAction('/api');
        
        $file	= new Zend_Form_Element_File('uploadFile');

        $submit	= new Zend_Form_Element_Submit('submit');
        $submit	->setValue('Upload');
        
        $this->addElements(array(
            $file,
            $submit
        ));
    }

}