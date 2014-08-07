<?php
/**
 * ApiController.php
 *
 * @author: Tristan Goguet <tristan.goguet@gmail.com>
 * Date: 02/08/2014
 */
class ApiController extends Controller {

    const moduleTitle = "Sig";
    public static $moduleKey = "sig";
    public $percent = 60; //TODO link it to unit test

    protected function beforeAction($action)
    {
        array_push($this->sidebar1, array('label' => "All Modules", "key"=>"modules","iconClass"=>"fa fa-th",  "menuOnly"=>true,"children"=>PH::buildMenuChildren("applications") ));
        return parent::beforeAction($action);
    }

    public function actions()
    {
        array_push($this->sidebar1,Api::getSigMap()); 
        return Api::buildActionMap($this->sidebar1);
    }
}