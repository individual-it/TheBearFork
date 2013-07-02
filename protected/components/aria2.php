<?php

/*  The Bear - a giant downlaoder
 
  Copyright (C) 2011 Behdad Kh.
 
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
 
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
  http://sourceforge.net/projects/thebear/
  
*/
	
	class aria2 {
		
		private $_items = null ;
		private $_globalStat = null ;
		private $_globalOption = null ;
		private $_error = null ;
		private $_host = null ;
		private $_port = null ;
		private $_rpc_user = null ;
		private $_rpc_passwd = null ;
		
		public function __construct() {
			$this->_host 		= Yii::app()->Setting->ariaHost ;
			$this->_port 		= Yii::app()->Setting->ariaPort ;
			$this->_rpc_user 	= Yii::app()->Setting->ariaRpcUser ;
			$this->_rpc_passwd 	= Yii::app()->Setting->ariaRpcPasswd ;
		}
		
		public function __call($method, $params) {
			return $this->_curl($method, $params) ;
		}
		
		private function _curl($method, $params) {
			
			$result = array() ;
			$ch = curl_init() ;
			
			$url = $this->_host.":".$this->_port."/jsonrpc" ;
			if (!is_null($this->_rpc_user) && !is_null($this->_rpc_passwd))
				$url = $this->_rpc_user.":".$this->_rpc_passwd."@".$url ;
			
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
			
			$data = CJSON::encode(array(
										"jsonrpc"=>"2.0",
										"id"=>"qwe",
										"method"=>"aria2.".$method,
										"params"=>$params
										)) ;		
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			
			$result = curl_exec($ch);
			if ($result==false) {
				throw new Exception('Unable to initiate a connection to: '.$this->_host.':'.$this->_port) ;
				return ;
			} 

			$result = CJSON::decode($result) ;
			
			if(isset($result['error'])) {
				$this->setError($result['error']['message']) ;
				Yii::log(print_r($result,true),'error',__METHOD__);
			} else
				$this->setError(null) ;
			
			if(isset($result['result']))
				$result = $result['result'] ;
			
			curl_close($ch);	
			
			return $result ;
			
		}		
		
		public function setGlobalOption($option,$value) {
			$this->changeGlobalOption(array($option=>$value)) ;
		}
		
		public function getGlobalOption($option) {
			$options = $this->getGlobalOptions() ;
			return $options[$option] ;
		}		
		
		public function getGlobalOptions () {
			if (!is_null($this->_globalOption))
				return $this->_globalOption ;
			$this->_globalOption = $this->_curl('getGlobalOption',array()) ;
			return $this->_globalOption ;
		}
		
		public function getError() {
			return $this->_error ;
		}
		
		private function setError($message) {
			$this->_error = $message ;
		}
		
		public function hasError() {
			return !is_null($this->_error) ;
		}
		
		public function getUris($gid) {
		
			$result = $this->getItemList() ;			
			$files = $result[0]->files;

			$uris = array() ;
			foreach($files as $key => $file) 
				foreach($file['uris'] as $key2 => $uri) 
					$uris[] = $uri['uri'];
			
			return $uris ;
			
		}
		
		public function getFilesPath($gid) {
			
			$result = $this->getItemList() ;
			$result = $result[0]->files;
			
			$paths = array() ;
			foreach($result as $key => $val)
				$paths[] = $val['path'];
			
			return $paths ;
			
		}
		
		public function totalDownloads() {
		
			$return = $this->getGlobalStats() ;
			
			$total = 0 ;
			$numbers = $return ; 
			$total +=  $numbers['numStopped'] ;
			$total +=  $numbers['numActive'] ;
			$total +=  $numbers['numWaiting'] ;
			
			return $total ;
			
		}
		
		public function getGlobalStats() {
			if (!is_null($this->_globalStat))
				return $this->_globalStat ;
				
			$this->_globalStat = $this->_curl('getGlobalStat',array()) ;
			
			return $this->_globalStat ;
		}
		
		public function getGlobalStat($stat) {
			$stats = $this->getGlobalStats() ;
			return $stats[$stat] ;
		}
		
		public function getItemList() {
			
			if (!is_null($this->_items))
				return $this->_items ;
			
			$result = array() ;
			$total = $this->totalDownloads() ;
			
			$active = $this->tellActive() ;
			if (sizeof($active))
				$result = $this->toObject($active) ;	

			$waiting = $this->tellWaiting(0, $total) ;
			if (sizeof($waiting))
				$result = array_merge($result,$this->toObject($waiting));

			$stopped = $this->tellStopped(0, $total) ;

			if (sizeof($stopped))
				$result = array_merge($result,$this->toObject($stopped));
			
			$this->_items = $result ;
			
			return $this->_items ;
			
		}
		
		private function toObject($array) {
			$result = array() ;
			foreach ($array as $key => $value) 
				array_push($result, new ariaItem($value)) ;
					
			return $result ;
		}
		
	}	
	
	
?>
