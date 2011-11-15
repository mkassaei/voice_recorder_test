<?php
$id = required_param('voicerecorder', PARAM_RAW);
if (!preg_match('~^[a-z][a-z0-9_-]*$~', $id)) {
    print_error("ERROR: $id is an invalid ID");
}

// Get target file
$target = $CFG->dataroot . '/temp/voicerecorder/' . $USER->id . '.' . sha1(rand()) . '.voice';
check_dir_exists(dirname($target), true, true);

// This is only for testing, we may get more accurate fileinfo
// from whererever the voicerecorder repository is called.
$fileinfo = new stdClass;
$fileinfo->contextid = get_context_instance(CONTEXT_SYSTEM)->id;
$fileinfo->component = 'user';
$fileinfo->filearea = 'draft';
$fileinfo->itemid = optional_param('itemid', 0, PARAM_INT);
$fileinfo->filepath = '/' . $USER->id . '/voicerecorder/';
$fileinfo->filename = $id . '.wav';

$fs = get_file_storage();
$file = $fs->get_file($fileinfo->contextid, $fileinfo->component, $fileinfo->filearea,
            $fileinfo->itemid, $fileinfo->filepath, $fileinfo->filename);

if ($file) {
    $file->delete();
}

$fs->create_file_from_pathname($fileinfo, $target);
unlink($target);

// Here we may add_to_log()
