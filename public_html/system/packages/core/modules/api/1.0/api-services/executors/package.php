<?php
# @Author: Andrea F. Daniele <afdaniele>
# @Date:   Monday, January 8th 2018
# @Email:  afdaniele@ttic.edu
# @Last modified by:   afdaniele
# @Last modified time: Wednesday, January 10th 2018



require_once __DIR__.'/../../../../../../../classes/Core.php';
use system\classes\Core as Core;

require_once __DIR__.'/../../../../../../../api/1.0/utils/utils.php';


function execute( &$service, &$actionName, &$arguments ){
	$action = $service['actions'][$actionName];
	//
	switch( $actionName ){
		case 'status':
			$is_enabled = Core::isPackageEnabled( $arguments['id'] );
			$data = [
				'package' => $arguments['id'],
				'enabled' => $is_enabled
			];
			//
			return response200OK( $data );
			break;
		//
		case 'enable':
			$res = Core::enablePackage( $arguments['id'] );
			if( !$res['success'] ){
				return response400BadRequest( $res['data'] );
			}
			//
			return response200OK( null );
			break;
		//
		case 'disable':
			$res = Core::disablePackage( $arguments['id'] );
			if( !$res['success'] ){
				return response400BadRequest( $res['data'] );
			}
			//
			return response200OK( null );
			break;
		//
		default:
			return response400NotFound( sprintf("The command '%s' was not found", $actionName) );
			break;
	}
}//execute

?>