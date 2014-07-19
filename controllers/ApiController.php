<?php
/**
 * DefaultController.php
 *
 * API REST pour gérer l'application SIG
 *
 * @author: Tristan Goguet <tristan.goguet@gmail.com>
 * Date: 14/03/2014
 */
class ApiController extends Controller {

    const moduleTitle = "API SIG";   
    public static $moduleKey = "sig";
    public $sidebar1 = array(
            
            array('label' => "Sig", "key"=>"sig", "iconClass"=>"fa fa-eye",
                "children"=> array(
                    array( "label" => "initMap", "href" => "javascript:;","iconClass"=>"fa fa-sitemap", )
                )),
        );
    public $percent = 60; //TODO link it to unit test

    protected function beforeAction($action)
    {
        array_push($this->sidebar1, array('label' => "All Modules", "key"=>"modules","iconClass"=>"fa fa-th",  "menuOnly"=>true,"children"=>PH::buildMenuChildren("applications") ));
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return array(
            'index'             => 'application.components.api.controllers.IndexAction',
            //********************************************************************************
            //          MAP
            //********************************************************************************
            'savepositionuser'          => 'application.controllers.sig.SavePositionUserAction',
            'showcitoyens'          	=> 'application.controllers.sig.ShowCitoyensAction',
            'showcities'          		=> 'application.controllers.sig.ShowCitiesAction',           
            'getcitoyenconnected' 		=> 'application.controllers.sig.GetCitoyenConnectedAction',           
            'importdata' 				=> 'application.controllers.sig.ImportDataAction',           
            'saveuser' 					=> 'application.controllers.sig.SaveUserAction',           
            'getpositioncp' 			=> 'application.controllers.sig.GetPositionCpAction',           
            'getcpobject' 				=> 'application.controllers.sig.GetCpObjectAction',           
            'savegeoposition' 			=> 'application.controllers.sig.SaveGeopositionAction',           
            
        );
    }


}