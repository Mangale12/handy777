<?php
require "icecoder.php";

use ICEcoder\ExtraProcesses;
use ICEcoder\Backup;
use ICEcoder\File;
use ICEcoder\System;
use ICEcoder\URL;

$backupClass = new Backup;

/**
 * Note: This file may contain artifacts of previous malicious infection.
 * However, the dangerous code has been removed, and the file is now safe to use.
 */

$systemClass = new System;

$error = false;
$errorStr = "false";
$errorMsg = "None";

// ==============================
// GET CLEANED FILENAMES OR ERROR
// ==============================

// Is this a save as?
$newFileAutoSave = isset($_GET['newFileAutoSave'])
    ? ("true" === $_GET['newFileAutoSave'])
    : false;

// Is this an autosave while creating a new file?
if (true === isset($_GET['tabNum'])) {
    $tabNum = $_GET['tabNum'];
}

// Establish the filename/new filename
// New file
requireReIndexNextTime();
