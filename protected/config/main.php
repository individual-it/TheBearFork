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

return array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'The Bear - a giant downloader',

		/*Artur Neumann INF www.inf.org
		 * we also need the intput helper from http://www.yiiframework.com/extension/input/
		 * for sanitizing the URL input passed by $_GET['url'] into the software
		 */
		'preload'=>array('log','input'),

		'import'=>array(
				'application.models.*',
				'application.components.*',
		),

		'modules'=>array(
		),

		'components'=>array(
				'Setting'=>array(
						'class'=>'AppSettingForm',
				),
				'user'=>array(
						'allowAutoLogin'=>true,
				),
				'errorHandler'=>array(
						'errorAction'=>'site/error',
				),
				'log'=>array(
						'class'=>'CLogRouter',
						'routes'=>array(
								array(
										'class'=>'CFileLogRoute',
										'levels'=>'info,error',
								),
								array(
										'class'=>'CWebLogRoute',
										'levels'=>'trace',
								),

						),
				),
				'input'=>array(
						'class'         => 'CmsInput',
						'cleanPost'     => false,
						'cleanGet'      => false,
				),

		),

		'params'=>array(
				'adminEmail'=>'webmaster@example.com',
		),

);
?>
