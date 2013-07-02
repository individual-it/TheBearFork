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

$yii=dirname(__FILE__).'/yii-1.1.8/framework/yiilite.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// Un comment these lines if you want to have the stack trace
#defined('YII_DEBUG') or define('YII_DEBUG',true);
#defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',4);

require_once($yii);

Yii::createWebApplication($config)->run();


