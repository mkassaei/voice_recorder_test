<?php
require_once('../config.php');
require_login();

// get id
if (isset($_REQUEST['id'])) {
    $id = required_param('id', PARAM_INT);
} else {
    $id = 12345;
}

// Init JavaScript
$jsmodule = array(
    'name' => 'vr',
    'fullpath' => '/voice_recorder_test/voicerecordertest.js',
    'requires' => array('base', 'node', 'yui2-dragdrop', 'yui2-animation'));

// Set up page object
$PAGE->set_url(new moodle_url($FULLME, array('id'=>$id)));
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
$PAGE->requires->js_init_call('M.vr.init', array($FULLME, 'string', 'pix'), false, $jsmodule);

print $OUTPUT->header();
print get_voice_recorder($id);
print $OUTPUT->footer();




function get_voice_recorder($id) {
    global $CFG, $USER;
    //jarfile = "$CFG->wwwroot/mod/oucontent/embeddedrecorder200906111142.jar";
    $jarfile = "$CFG->wwwroot/voice_recorder_test/embeddedrecorder200906111142.jar";
    $width = 200;
    $height = 100;
    $appletclass = "uk.ac.open.embeddedrecorder.EmbeddedRecorderApplet";
    //$upload = "$CFG->wwwroot/mod/oucontent/voicerecorderupload.php?id=$id" . "'+String.fromCharCode(38)+'voicerecorder=mk";
    $upload = "$CFG->wwwroot/voice_recorder_test/voicerecorderupload.php?id=$id" . "'+String.fromCharCode(38)+'voicerecorder=mk";
    
    $contextid = 68;
    $component = 'mod_oucontent';
    $filearea = 'oucontent_userdata';
    $itemid = 25;
    $filepath = "$USER->id/voicerecorder";
    $filename = 'mk.wav';
    //$user = "wwwroot/pluginfile.php/contextid/component/filearea/itemid/filepath/filename?hash=a8ce1cfbb63112673f9a46f2e1c9066f530366de";
    //$user = "$CFG->wwwroot/pluginfile.php/$contextid/$component/$filearea/$itemid/$filepath/$filename?hash=a8ce1cfbb63112673f9a46f2e1c9066f530366de";
    //print_object($user);
    $colours = "#333333, #AAAAAA, #CCCCCC, #333300, #AAAA00, #CCCC00, #CCCCCC";
    //$colours = "#4B0082, #4B0082, #CCCCCC, #333300, #AAA000, #CCCC00, #CCCCCC";
    $strings = "Listen, Record, Play back, Model, Stop, Cancel";

    return "testing voice recorder
        <div id='voicerecorder$id' class='voice-recorder-applet'></div>
        
        <script type='text/javascript'>
            var n = document.getElementById('voicerecorder$id');
            n.type = 'java';
            n.params = {
                java : '$jarfile',
                width: $width,
                height: $height,
                appletclass: '$appletclass',
                javavars : [
                    'upload', '$upload',
                    'strings', '$strings',
                    'colours', '$colours',
                    'order', 'LISTENFIRST'
                ]
            };
        </script>";
}
