<?php

require_once 'PEAR/PackageFileManager.php';

$version = '2.0.0RC5';
$notes = <<<EOT
- expanded testing of prepared queries (out of order binding, escape characters
  inside the string, lobs without named parameters that match the field name)
- removed ugly hack for quote parameter in quote() since it was insufficient
  (escaping also needs to be prevented)
- added support for out of order parameter binding in prepared queries
- expanded testing of prepared queries (out of order binding, escape characters
  inside the string, lobs without named parameters that match the field name)
- reset row_limit and row_offset after calling prepare() just like we do for query() and exec()
- cosmetic fix (removed "row_" prefix from "row_limit" and "row_offset")
- now using INT/TINYINT/SMALLINT by default instead of CHAR(1) for the boolean datatype
  (BC BREAK!)
- added MDB2_datatype_testcase to test suite
- support an arbitrary number of arguments in concat()
- add property phpdoc comments to LOB.php
EOT;

$description =<<<EOT
PEAR MDB2 is a merge of the PEAR DB and Metabase php database abstraction layers.

Note that the API will be adapted to better fit with the new php5 only PDO
before the first stable release.

It provides a common API for all supported RDBMS. The main difference to most
other DB abstraction packages is that MDB2 goes much further to ensure
portability. Among other things MDB2 features:
* An OO-style query API
* A DSN (data source name) or array format for specifying database servers
* Datatype abstraction and on demand datatype conversion
* Various optional fetch modes to fix portability issues
* Portable error codes
* Sequential and non sequential row fetching as well as bulk fetching
* Ability to make buffered and unbuffered queries
* Ordered array and associative array for the fetched rows
* Prepare/execute (bind) emulation
* Sequence emulation
* Replace emulation
* Limited sub select emulation
* Row limit support
* Transactions support
* Large Object support
* Index/Unique Key/Primary Key support
* Autoincrement emulation
* Module framework to load advanced functionality on demand
* Ability to read the information schema
* RDBMS management methods (creating, dropping, altering)
* Reverse engineering schemas from an existing DB
* SQL function call abstraction
* Full integration into the PEAR Framework
* PHPDoc API documentation
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(
    array(
        'package'           => 'MDB2',
        'summary'           => 'database abstraction layer',
        'description'       => $description,
        'version'           => $version,
        'state'             => 'beta',
        'license'           => 'BSD License',
        'filelistgenerator' => 'cvs',
        'ignore'            => array('package*.php', 'package*.xml', 'sqlite*', 'mssql*', 'oci8*', 'pgsql*', 'mysqli*', 'mysql*', 'fbsql*', 'querysim*', 'ibase*', 'peardb*'),
        'notes'             => $notes,
        'changelogoldtonew' => false,
        'simpleoutput'      => true,
        'baseinstalldir'    => '/',
        'packagedirectory'  => './',
        'dir_roles'         => array(
            'docs' => 'doc',
             'examples' => 'doc',
             'tests' => 'test',
        ),
    )
);

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->addMaintainer('lsmith', 'lead', 'Lukas Kahwe Smith', 'smith@pooteeweet.org');
$package->addMaintainer('pgc', 'contributor', 'Paul Cooper', 'pgc@ucecom.com');
$package->addMaintainer('quipo', 'contributor', 'Lorenzo Alberton', 'l.alberton@quipo.it');
$package->addMaintainer('danielc', 'helper', 'Daniel Convissor', 'danielc@php.net');
$package->addMaintainer('davidc', 'helper', 'David Coallier', 'david@jaws.com.mx');

$package->addDependency('php', '4.3.0', 'ge', 'php', false);
$package->addDependency('PEAR', '1.3.6', 'ge', 'pkg', false);

$package->addglobalreplacement('package-info', '@package_version@', 'version');

if (array_key_exists('make', $_GET) || (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make')) {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
