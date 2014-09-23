<?php
/**
 * DefaultController.php
 *
 * OneScreenApp for Communecting people
 *
 * @author: Tristan Goguet <tristan.goguet@gmail.com>
 * Date: 14/03/2014
 */
class DefaultController extends Controller {

    const moduleTitle = "SIG";
    public $keywords = "";
    public $description = "";
    public static $moduleKey = "sig";

	//tu peux utiliser ceci comm ton menu
    public $sidebar1 = array(
      
    );
    
    protected function beforeAction($action)
  	{
  		Yii::app()->theme  = "juntos";
		return parent::beforeAction($action);
  	}

    /**
     * List all the latest observations
     * @return [json Map] list
     */
	public function actionIndex() 
	{
     
	    $this->render( "index" );
	}

  
  
}
