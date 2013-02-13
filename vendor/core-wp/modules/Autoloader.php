<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Registers an Autoloader
 *
 * The Autoloader works out of the box as simple as possible. You have
 * nothing more to do than require this file. Don't bother the time it
 * consumes when it's called the first time. Let it build its index.
 * The second time it will run as fast as light.
 *
 * The simplest and probably most common use case shows this example:
 *
 * index.php
 * <code>
 * <?php
 * require dirname(__FILE__) . "/autoloader/Autoloader.php";
 * $myObject = new MyClass();
 * </code>
 * 
 * classes/MyClass.php
 * <code>
 * <?php
 * class MyClass extends MyParentClass
 * {
 *
 * }
 * </code>
 * 
 * classes/MyParentClass.php
 * <code>
 * <?php
 * class MyParentClass
 * {
 *
 * }
 * </code>
 * 
 * As you can see it's only necessary to require this file once.
 * If this is done in the document root of your classes (index.php in
 * this case) the Autoloader is already configured. After requiring
 * this file you don't have to worry where your classes reside.
 *
 * Another use case would have the class path outside of your document root.
 * As the autoloader has no knowledge of this arbitrary path you have to
 * tell him where your class path is:
 *
 * <code>
 * <?php
 * require dirname(__FILE__) . "/autoloader/Autoloader.php";
 *
 * // As the guessed class path is wrong you should remove this Autoloader.
 * Autoloader::getRegisteredAutoloader()->remove();
 *
 * // register your arbitrary class path
 * $autoloader = new Autoloader($classpath);
 * $autoloader->register();
 *
 * // You might also have other class paths
 * $autoloader2 = new Autoloader($classpath2);
 * $autoloader2->register();
 * </code>
 *
 * If you have the possibility to enable PHP's tokenizer you should do
 * this. Otherwise the Autoloader has to use a parser based on PCRE
 * which is not as reliable as PHP's tokenizer.
 *
 * The Autoloader assumes that a class name is unique. If you have classes with
 * equal names the behaviour is undefined.
 *
 * PHP version 5
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.
 * If not, see <http://php-autoloader.malkusch.de/en/license/>.
 *
 * @category  PHP
 * @package   Autoloader
 * @author    Markus Malkusch <markus@malkusch.de>
 * @copyright 2009 - 2010 Markus Malkusch
 * @license   http://php-autoloader.malkusch.de/en/license/ GPL 3
 * @version   SVN: $Id$
 * @link      http://php-autoloader.malkusch.de/en/
 * @see       Autoloader
 */

/**
 * Another library might use this Autoloader in another package as well. In that
 * case a copy of the Autoloader package exists at a different location in the
 * file system. If the Autoloader classes are already loaded by that copy an
 * include_once would still include the files of this copy, which would lead
 * to a fatal error. To avoid this, the classes are only loaded if the class
 * Autoloader is not defined yet.
 */
if (! class_exists('Autoloader')) {
    include_once dirname(__FILE__) . "/Autoloader/OldPHPAPI.php";
    $__oldAPI = new OldPHPAPI();
    $__oldAPI->checkAPI();
    unset($__oldAPI);

    include_once dirname(__FILE__) . "/Autoloader/Autoloader.php";

}

/**
 * A new instance of Autoloader is created and registered into the spl_autoload()
 * stack. The class path of that instance is the directory of the file which
 * has included this file.
 *
 * @see Autoloader::__construct()
 * @see Autoloader::getCallersPath()
 * @see Autoloader::register()
 */
$__autoloader = new Autoloader();
$__autoloader->register();
unset($__autoloader);
