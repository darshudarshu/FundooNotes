<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'welcome';
// $route['Register1'] = 'Register/Register1';
// $route['insert'] = 'Api/insert';
// $route['fetchall'] = 'Api/fetchAll';
// $route['update'] = 'Api/update';
// $route['fetchOne'] = 'Api/fetchOne';
// $route['delete'] = 'Api/delete';
// $route['sample']               = 'Sample/insert';
$route['caller']               = 'Testapi/caller';
$route['check']                = 'Api/check';
$route['404_override']         = '';
$route['translate_uri_dashes'] = false;
$route['registration']         = 'FundoAPI/registration';
$route['login']                = 'FundoAPI/login';
$route['forgotPassword']       = 'FundoAPI/forgotPassword';
$route['resetPassword']        = 'FundoAPI/resetPassword';
$route['getEmailId']           = 'FundoAPI/getEmailId';
$route['veryfyEmailId']        = 'FundoAPI/veryfyEmailId';
// $route['verifyToken']          = 'FundoAPI/verifyToken';

$route['createNotes']     = 'NotesController/createNotes';
$route['userNotes']       = 'NotesController/userNotes';
$route['changeColor']     = 'NotesController/changeColor';
$route['changeDateTime']  = 'NotesController/changeDateTime';
$route['deleteNote']      = 'NotesController/deleteNote';
$route['editNotes']       = 'NotesController/editNotes';
$route['addLabel']        = 'NotesController/addLabel';
$route['saveLabels']      = 'NotesController/saveLabels';
$route['changeLabel']     = 'NotesController/changeLabel';
$route['deleteLabel']     = 'NotesController/deleteLabel';
$route['noteLabel']       = 'NotesController/noteLabel';
$route['deleteNoteLabel'] = 'NotesController/deleteNoteLabel';
$route['dragDrop']        = 'NotesController/dragDrop';

$route['archiveNote']        = 'ArchiveController/archiveNote';
$route['fetchArchiveNote']   = 'ArchiveController/fetchArchiveNote';
$route['fetchUnArchiveNote'] = 'ArchiveController/fetchUnArchiveNote';
$route['deleteArchiveNote']  = 'ArchiveController/deleteArchiveNote';

$route['fetchRemainderNote']      = 'RemainderController/fetchRemainderNote';
$route['changeRemainderDateTime'] = 'RemainderController/changeDateTime';
$route['createRemainderNotes']    = 'RemainderController/createRemainderNotes';
$route['deleteRemainderNote']     = 'RemainderController/deleteRemainderNote';

$route['restoreDeletedNote'] = 'TrashController/restoreDeletedNote';
$route['fetchTrashNote']     = 'TrashController/fetchTrashNote';
$route['deleteTrashNote']    = 'TrashController/deleteNote';

$route['fetchLabelNote']      = 'LabelController/fetchLabelNote';
$route['changeLabelDateTime'] = 'LabelController/changeLabelDateTime';
$route['createLabelNotes']    = 'LabelController/createLabelNotes';
$route['deleteLabelNote']     = 'LabelController/deleteLabelNote';
$route['deleteNoteLabels']    = 'LabelController/deleteNoteLabels';

$route['addCollabarator']               = 'Collabarator/addCollabarator';
$route['fetchCollabarators']            = 'Collabarator/fetchCollabarators';
$route['fetchOwner']                    = 'Collabarator/fetchOwner';
$route['deleteCollabaratorData']        = 'Collabarator/deleteCollabaratorData';
$route['collabaratorsOfNotes']          = 'Collabarator/collabaratorsOfNotes';
$route['deleteMainCollabaratorData']    = 'Collabarator/deleteMainCollabaratorData';
$route['deleteAllMainCollabaratorData'] = 'Collabarator/deleteAllMainCollabaratorData';

$route['fetchImage'] = 'ImageController/fetchImage';
$route['saveImage']  = 'ImageController/saveImage';
$route['saveImage'] = 'ImageController/noteSaveImage';


