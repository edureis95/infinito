<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	//app('App\Http\Controllers\CardDavController')->updateContacts();
    return view('welcome');
});



Route::middleware('auth')->group(function () {

	Route::get('/changeDefaultPassword', 'ChangeDefaultPasswordController@getChangePasswordForm');

	Route::middleware('checkDefaultUser')->group(function() {
		Route::get('/home', 'HomeController@index');

		Route::middleware('company')->group(function () {
			//company
			Route::get('company/showCompanyMembers/{id}', 'CompanyController@company_members');
			Route::get('/structure', 'CompanyController@company_structure');
			Route::post('/structure/add_department', 'CompanyController@add_department');
			Route::post('/structure/add_user', 'CompanyController@add_user');
			Route::post('/structure/edit_department', 'CompanyController@edit_department');
			Route::post('/structure/delete_department', 'CompanyController@delete_department');
			Route::get('/company/absence', 'CompanyController@showAbsenceCalendar');
			Route::match(['get', 'post'], '/absence_data', 'CompanyController@data');
			Route::get('/company/absence/getReasons', 'CompanyController@getAbsenceReasons');
			Route::get('/company/absence/getUserName/{id}', 'CompanyController@getUserName');
			Route::get('/company/absence/getUserNamesList', 'CompanyController@getUserNamesList');
		});

		Route::middleware('projects')->group(function () {
			//project
			Route::post('/removeProjectTask', 'ProjectController@removeProjectTask');
			Route::post('/project/team/editMember', 'ProjectController@editTeamMember');
			Route::get('projects', 'ProjectController@show_projects');
			Route::get('projects/new', 'ProjectController@create_project_form');
			Route::post('projects/new', 'ProjectController@create_project');
			Route::post('projects/client/new', 'ProjectController@create_client');
			Route::get('project/{id}', 'ProjectController@show_project');
			Route::get('project/{id}/properties', 'ProjectController@show_project_properties');
			Route::post('/getExpertiseFromProject', 'ProjectController@getExpertiseFromProject');
			Route::post('/getExpertisePhasesFromProject', 'ProjectController@getExpertisePhasesFromProject');
			Route::post('/getProgrammedTask', 'ProjectController@getProgrammedTask');
			Route::post('/saveTaskTime', 'ProjectController@saveTaskTime');
			Route::post('/saveProgrammedTaskTime', 'ProjectController@saveProgrammedTaskTime');
			Route::post('/projects/edit', 'ProjectController@editProject');
			Route::post('/projects/removeProject', 'ProjectController@removeProject');
			Route::get('/project/{id}/planning', 'ProjectController@getPlanning');
			Route::post('/project/{id}/planning/addPlanning', 'ProjectController@addPlanning');
			Route::get('/project/team/{id}', 'ProjectController@getTeam');
			Route::get('/project/outsideTeam/{id}', 'ProjectController@getOutsideTeam');
			Route::post('/project/team/addMember/{id}', 'ProjectController@addMember');
			Route::post('/project/team/addOutsideMember/{id}', 'ProjectController@addOutsideMember');
			//Activities
			Route::get('activity/new', 'ActivityController@create_activity_form');
			Route::post('activity/new', 'ActivityController@create_activity');
			//tasks
			Route::get('task/new', 'TaskController@create_task_form');
			Route::post('task/new', 'TaskController@create_task');
			//gantt chart
			Route::get('/gantt', function () {
				return view('gantt');
			});
			Route::match(['get', 'post'], '/gantt_data', "GanttController@data");
			Route::get('/planning', "GanttController@gantt");
			Route::get('/project/deletePlanning/{id}', 'ProjectController@deletePlanning');
			Route::get('/project/gantt/{id}', 'ProjectController@getGantt');
			Route::get('/project/deleteTeamMember/{id}', 'ProjectController@deleteTeamMember');
			Route::get('/project/deleteOutsideTeamMember/{id}', 'ProjectController@deleteOutsideTeamMember');
			Route::get('/project/expertise/{id}', 'ProjectController@getExpertise');
			Route::post('/project/expertise/addExpertise/{id}', 'ProjectController@addExpertise');
			Route::get('/project/deleteExpertise/{id}', 'ProjectController@deleteExpertise');
			Route::get('/project/phases/{id}', 'ProjectController@getPhases');
			Route::post('/project/phases/addPhase/{id}', 'ProjectController@addPhase');
			Route::get('/project/deletePhase/{id}', 'ProjectController@deletePhase');
			Route::get('/projects/getProjectDetails/{id}', 'ProjectController@getProjectDetails');
			Route::post('/projects/filterProjects', 'ProjectController@filterProjects');
			Route::get('/project/tasks/{id}', 'ProjectController@getProjectTasks');
			Route::post('project/tasks/addTask/{id}', 'ProjectController@addTask');
			Route::get('/project/tasks/removeTask/{id}', 'ProjectController@removeTask');
			Route::get('/project/events/{id}', 'ProjectController@getProjectEvents');
			Route::post('/project/events/addEvent/{id}', 'ProjectController@addEvent');
			Route::get('/project/events/removeEvent/{id}', 'ProjectController@removeEvent');
			Route::get('/project/report/{id}', 'ProjectController@getProjectReport');
			Route::post('/project/editCaracterization', 'ProjectController@editProjectCaracterization');
			Route::post('/project/editDescription', 'ProjectController@editDescription');
			Route::post('/project/gantt/editTaskTime', 'ProjectController@editProjectTaskTime');
			Route::get('/project/executedTasks/{id}', 'ProjectController@getProjectExecutedTasks');
			Route::post('/project/executedTasks/addTask/{id}', 'ProjectController@addProjectExecutedTask');
			Route::post('/project/executedTasks/editNote', 'ProjectController@editExecutedTaskNote');
			Route::post('/project/plannedTasks/editNote', 'ProjectController@editPlannedTaskNote');
			Route::post('/project/task_timer/editNote', 'ProjectController@editTaskTimerNote');
			Route::post('/project/expertise/editExpertisePhases', 'ProjectController@editProjectExpertisePhases');
			Route::post('/project/executedTasks/editTask', 'ProjectController@editProjectExecutedTask');
			Route::post('/project/executedTasks/getTaskDetails', 'ProjectController@getExecutedTaskDetails');
			Route::post('/project/plannedTasks/getTaskDetails', 'ProjectController@getPlannedTaskDetails');
			Route::post('/project/gantt/getPlannedTaskDetails', 'ProjectController@getPlannedTaskDetailsFromGantt');
			Route::post('/project/gantt/editPlannedTaskFromGantt', 'ProjectController@editPlannedTaskFromGantt');
			Route::post('/project/gantt/editPlannedTaskFromGeneralGantt', 'ProjectController@editPlannedTaskFromGeneralGantt');
			Route::post('/project/plannedTasks/editTask', 'ProjectController@editPlannedTask');
			Route::get('getProject/{id}', 'ProjectController@getProject');
			Route::get('/emailAndDepartmentFromUser/{id}', 'ProjectController@getEmailAndDepartmentFromUser');
			Route::get('/emailAndPhoneFromContact/{id}', 'ProjectController@getEmailAndPhoneFromContact');
			Route::post('/project/outsideTeam/editMember', 'ProjectController@editProjectOutsideTeamMember');
		});

		Route::middleware('calendar')->group(function () {
			//Scheduler
			Route::get('/scheduler', 'CalDavController@getEventsFormatted');
			Route::post('/scheduler/addPlannedTask', 'SchedulerController@addPlannedTask');
			Route::post('/scheduler/addEventToCalDav','CalDavController@addEventToCalDav');
			Route::match(['get', 'post'], '/scheduler_data', "SchedulerController@data");
			Route::get('/calendar', function() {
				return view('roundcubeCalendar');
			});
		});




		Route::get('notifications', 'NotificationController@getIndex');
		Route::post('notifications/notify', 'NotificationController@postNotify');

		Route::post('chat/message/{chat}', 'ChatController@postMessage');
		Route::get('chatUser/createChannel/{user}', 'ChatController@createChannel');
		Route::get('chat/message/{chat}', 'ChatController@getMessages');
		Route::get('createChat/{user}', 'ChatController@createChat');



		Route::middleware('settings')->group(function () {
			Route::get('/settings', 'SettingsController@getUsersSettings');
			Route::get('/settings/projects/expertise', 'SettingsController@getProjectsExpertise');
			Route::get('/settings/projects/phases', 'SettingsController@getProjectsPhases');
			Route::post('/settings/projects/expertise/edit', 'SettingsController@editProjectExpertise');
			Route::post('/settings/addExpertise', 'SettingsController@addExpertise');
			Route::post('/settings/addSubExpertise', 'SettingsController@addSubExpertise');
			Route::post('/settings/addPhase', 'SettingsController@addPhase');
			Route::get('/deleteUser/{id}', 'SettingsController@deleteUser');
			Route::get('/expertiseWithParent', 'SettingsController@getExpertiseWithParent');
			Route::get('/settings/projects/phases/deletePhase/{id}', 'SettingsController@removePhase');
			Route::get('/settings/projects/expertise/deleteExpertise/{id}', 'SettingsController@removeExpertise');
			Route::get('/settings/users/permissions', 'SettingsController@getPermissions');
			Route::post('/settings/users/permissions/savePermissions', 'SettingsController@savePermissions');
			Route::get('/settings/users/profiles', 'SettingsController@getProfiles');
			Route::post('/settings/users/profiles/addProfile', 'SettingsController@addProfile');
			Route::get('/settings/users/profiles/removeProfile/{id}', 'SettingsController@removeProfile');
			Route::post('/settings/users/changeUserPermission', 'SettingsController@changeUserPermission');
			Route::post('/addCollaborator', 'AddCollaboratorController@addCollaborator');
			Route::get('/settings/company/absence', 'SettingsController@showAbsence');
			Route::post('/settings/company/absence/addReason', 'SettingsController@addAbsenceReason');
			Route::get('/settings/company/absence/removeReason/{id}', 'SettingsController@removeAbsenceReason');
			Route::post('/settings/projects/expertise/changeExpertiseCode', 'SettingsController@changeExpertiseCode');
			Route::post('/settings/projects/expertise/changeExpertiseSigla', 'SettingsController@changeExpertiseSigla');
			Route::post('/settings/projects/expertise/changeExpertiseName', 'SettingsController@changeExpertiseName');
			Route::post('/settings/projects/phases/changePhaseCode', 'SettingsController@changePhaseCode');
			Route::post('/settings/projects/phases/changePhaseSigla', 'SettingsController@changePhaseSigla');
			Route::post('/settings/projects/phases/changePhaseName', 'SettingsController@changePhaseName');
			Route::get('/settings/projects/types', 'SettingsController@getTypes');
			Route::post('/settings/addProjectType', 'SettingsController@addProjectType');
			Route::get('/settings/projects/types/deleteProjectType/{id}', 'SettingsController@deleteProjectType');
			Route::post('/settings/projects/types/changeTypeCode', 'SettingsController@changeTypeCode');
			Route::post('/settings/projects/types/changeTypeSigla', 'SettingsController@changeTypeSigla');
			Route::post('/settings/projects/types/changeTypeName', 'SettingsController@changeTypeName');
			Route::get('/settings/projects/planning', 'SettingsController@getPlanning');
			Route::post('/settings/addPlanningType', 'SettingsController@addPlanningType');
			Route::get('/settings/projects/planning/deletePlanningType/{id}', 'SettingsController@deletePlanningType');
			Route::post('/settings/projects/planning/changeTypeCode', 'SettingsController@changePlanningTypeCode');
			Route::post('/settings/projects/planning/changeTypeSigla', 'SettingsController@changePlanningTypeSigla');
			Route::post('/settings/projects/planning/changeTypeName', 'SettingsController@changePlanningTypeName');
			Route::get('/settings/projects/states', 'SettingsController@getStates');
			Route::post('/settings/addStateType', 'SettingsController@addStateType');
			Route::get('/settings/projects/states/deleteStateType/{id}', 'SettingsController@deleteStateType');
			Route::post('/settings/projects/states/changeTypeCode', 'SettingsController@changeStateTypeCode');
			Route::post('/settings/projects/states/changeTypeSigla', 'SettingsController@changeStateTypeSigla');
			Route::post('/settings/projects/states/changeTypeName', 'SettingsController@changeStateTypeName');
			Route::get('/settings/projects/documentTypes', 'SettingsController@getDocumentTypes');
			Route::post('/settings/addDocumentTypes', 'SettingsController@addDocumentTypes');
			Route::get('/settings/projects/documentTypes/deleteDocumentType/{id}', 'SettingsController@deleteDocumentType');
			Route::post('/settings/projects/documentTypes/changeTypeCode', 'SettingsController@changeDocumentTypeCode');
			Route::post('/settings/projects/documentTypes/changeTypeSigla', 'SettingsController@changeDocumentTypeSigla');
			Route::post('/settings/projects/documentTypes/changeTypeName', 'SettingsController@changeDocumentTypeName');
			Route::get('/settings/projects/documents', 'SettingsController@getDocuments');
			Route::post('/settings/addDocument', 'SettingsController@addDocument');
			Route::get('/settings/projects/document/deleteDocument/{id}', 'SettingsController@deleteDocument');
			Route::post('/settings/projects/document/changeTypeCode', 'SettingsController@changeDocumentCode');
			Route::post('/settings/projects/document/changeTypeSigla', 'SettingsController@changeDocumentSigla');
			Route::post('/settings/projects/document/changeTypeName', 'SettingsController@changeDocumentName');
			Route::post('/settings/projects/document/changeTypeSpecialCode', 'SettingsController@changeDocumentSpecialCode');
			Route::post('/settings/projects/document/changeType', 'SettingsController@changeDocumentType');
			Route::get('/settings/company/holidays', 'SettingsController@getHolidays');
			Route::post('/settings/company/holidays/addDays', 'SettingsController@addHolidayDays');
			Route::get('/settings/company/holidays/removeHoliday/{id}', 'SettingsController@removeHoliday');
			Route::get('/settings/company/calendar', 'SettingsController@getCompanyDays');
			Route::post('/settings/company/calendar/addDay', 'SettingsController@addCompanyDay');
			Route::get('/settings/company/calendar/removeDay/{id}', 'SettingsController@removeCompanyDay');
			Route::post('/settings/company/calendar/getByYear', 'SettingsController@getCompanyDaysByYear');
			Route::get('/settings/projects/constructionTypes', 'SettingsController@getConstructionTypes');
			Route::post('/settings/project/addConstructionType', 'SettingsController@addConstructionType');
			Route::get('/settings/project/removeConstructionType/{id}', 'SettingsController@removeConstructionType');
			Route::get('settings/projects/utilizationTypes', 'SettingsController@getUtilizationTypes');
			Route::post('/settings/project/addUtilizationType', 'SettingsController@addUtilizationType');
			Route::get('/settings/project/removeUtilizationType/{id}', 'SettingsController@removeUtilizationType');
			Route::get('/settings/projects/eventTypes', 'SettingsController@getEventTypes');
			Route::post('/settings/addProjectEventType', 'SettingsController@addProjectEventType');
			Route::post('/settings/projects/phases/edit', 'SettingsController@editProjectPhases');
			Route::post('/settings/projects/types/edit', 'SettingsController@editProjectTypes');
			Route::post('/settings/projects/constructionTypes/edit', 'SettingsController@editProjectConstructionTypes');
			Route::post('/settings/projects/utilizationTypes/edit', 'SettingsController@editProjectUtilizationTypes');
			Route::get('/settings/projects/generalUserFunction', 'SettingsController@getProjectGeneralUserFunction');
			Route::post('/settings/projects/generalUserFunction/addFunction', 'SettingsController@addProjectGeneralUserFunction');
			Route::get('/settings/projects/userFunction', 'SettingsController@getProjectUserFunction');
			Route::post('/settings/projects/userFunction/addFunction', 'SettingsController@addProjectUserFunction');
			Route::get('/settings/projects/generalExpertise', 'SettingsController@getGeneralExpertise');
			Route::post('/settings/projects/generalExpertise/addGeneralExpertise', 'SettingsController@addGeneralExpertise');
			Route::get('/settings/contacts/types', 'SettingsController@getContactTypes');
			Route::post('/settings/contacts/types/addType', 'SettingsController@addContactType');
			Route::get('/settings/contacts/sources', 'SettingsController@getContactSources');
			Route::post('/settings/contacts/sources/addSource', 'SettingsController@addContactSource');
			Route::get('/settings/commercial/iva', 'SettingsController@getIVASettings');
			Route::post('/settings/commercial/iva/addIva', 'SettingsController@addIva');
			Route::get('/settings/commercial/hourlyRate', 'SettingsController@getHourlyRate');
			Route::post('/settings/commercial/hourlyRate/addRate', 'SettingsController@addHourlyRate');
			Route::get('/settings/contacts/companyTypes', 'SettingsController@getCompanyContactTypes');
			Route::post('/settings/contacts/companyTypes/addType', 'SettingsController@addCompanyContactType');
			Route::get('/settings/contacts/companyFields', 'SettingsController@getCompanyContactFields');
			Route::post('/settings/contacts/companyField/addType', 'SettingsController@addCompanyContactField');
			Route::get('/settings/contacts/companyDimensions', 'SettingsController@getCompanyContactDimensions');
			Route::post('/settings/contacts/companyDimension/addType', 'SettingsController@addCompanyContactDimension');
			Route::post('/settings/contacts/types/editType', 'SettingsController@editContactType');
			Route::post('/settings/contacts/types/removeType', 'SettingsController@removeContactType');
			Route::post('/settings/contacts/sources/editSource', 'SettingsController@editContactSource');
			Route::post('/settings/contacts/source/removeSource', 'SettingsController@removeContactSource');
			Route::post('/settings/contacts/companyTypes/editType', 'SettingsController@editCompanyContactType');
			Route::post('//settings/contacts/companyTypes/removeType', 'SettingsController@removeCompanyContactType');
			Route::post('/settings/contacts/companyFields/editField', 'SettingsController@editCompanyContactField');
			Route::post('/settings/contacts/companyFields/removeField', 'SettingsController@removeCompanyContactField');
			Route::post('/settings/contacts/companyDimensions/editDimension', 'SettingsController@editCompanyContactDimension');
			Route::post('/settings/contacts/companyDimensions/removeDimension', 'SettingsController@removeCompanyContactDimension');
			Route::post('/settings/company/absence/editReason', 'SettingsController@editAbsenceReason');
			Route::post('/settings/projects/generalExpertise/editExpertise', 'SettingsController@editGeneralExpertise');
			Route::post('/settings/projects/generalExpertise/removeExpertise', 'SettingsController@removeGeneralExpertise');
			Route::post('/settings/projects/planning/editPlanningType', 'SettingsController@editPlanningType');
			Route::post('/settings/contacts/projects/removePlanningType', 'SettingsController@removePlanningType');
			Route::post('/settings/projects/userFunction/editFunction', 'SettingsController@editProjectUserFunction');
			Route::post('/settings/projects/userFunction/removeFunction', 'SettingsController@removeProjectUserFunction');
			Route::post('/settings/projects/generalUserFunction/editFunction', 'SettingsController@editProjectGeneralUserFunction');
			Route::post('/settings/projects/generalUserFunction/removeFunction', 'SettingsController@removeProjectGeneralUserFunction');
		});

		Route::middleware('email')->group(function () {
			Route::get('/mail', 'EmailController@getRoundCubeMail');
			Route::post('mailSeen', 'EmailController@setSeen');
			Route::post('setMailPassword', 'EmailController@setMailPassword');
		});

		Route::middleware('management')->group(function () {
			Route::get('management', 'ManagementController@showManagement');
			Route::get('management/operations', 'ManagementController@showOperations');
			Route::get('management/absence', 'ManagementController@getAbsenceApproval');
			Route::post('management/absenceApproval/saveApproval', 'ManagementController@saveAbsenceApproval');
			Route::post('management/absenceApproval/saveReject', 'ManagementController@saveAbsenceReject');
			Route::post('management/absenceApproval/filter', 'ManagementController@filterAbsenceApproval');
			Route::get('management/project/{id}', 'ManagementController@getProject');
			Route::get('management/project/team/{id}', 'ManagementController@getProjectTeam');
			Route::get('management/project/expertise/{id}', 'ManagementController@getProjectExpertise');
			Route::get('management/project/phases/{id}', 'ManagementController@getProjectPhases');
			Route::get('management/project/planning/{id}', 'ManagementController@getProjectPlanning');
			Route::get('management/commercial', 'ManagementController@getCommercial');
			Route::post('commercialProjects/new', 'ManagementController@createCommercialProject');
			Route::get('commercialProject/showProject/{id}', 'ManagementController@getCommercialProject');
			Route::post('commercialProject/editCaracterization', 'ManagementController@editCommercialProjectCaracterization');
			Route::post('commercialProject/editDescription', 'ManagementController@editCommercialProjectDescription');
			Route::get('commercialProject/expertise/{id}', 'ManagementController@getCommercialProjectExpertise');
			Route::get('commercialProject/client/{id}', 'ManagementController@getCommercialProjectClient');
			Route::get('commercialProject/contract/{id}', 'ManagementController@getCommercialProjectContract');
			Route::post('management/operations/filterProjects', 'ManagementController@filterProjects');
			Route::post('commercialProject/client/savePersonalClient', 'ManagementController@saveCommercialProjectPersonalClient');
			Route::post('/commercialProject/expertise/addExpertise/{id}', 'ManagementController@addCommercialProjectExpertise');
			Route::post('commercialProject/phases/addPhase/{id}', 'ManagementController@addCommercialProjectPhase');
			Route::post('/commercialProject/expertise/editExpertisePhases', 'ManagementController@editCommercialProjectExpertisePhases');
			Route::get('/commercialProject/plannedTasks/{id}', 'ManagementController@getCommercialProjectPlannedTasks');
			Route::post('/commercialProject/{id}/addPlannedTask', 'ManagementController@addCommercialProjectPlannedTask');
			Route::get('/commercialProject/planningTasks/{id}', 'ManagementController@getCommercialProjectPlanningTasks');
			Route::post('/commercialProject/addPlanningTask/{id}', 'ManagementController@addCommercialProjectPlanningTask');
			Route::get('/commercialProject/executedTasks/{id}', 'ManagementController@getCommercialProjectExecutedTasks');
			Route::post('/commercialProject/addExecutedTask/{id}', 'ManagementController@addCommercialProjectExecutedTask');
		});

		Route::middleware('contacts')->group(function () {
			Route::get('/contacts', 'CardDavController@getContacts');
			Route::get('/syncContacts', 'CardDavController@updateContacts');
			Route::post('/contacts/createContact', 'CardDavController@createContact');
			Route::get('/contacts/company', 'CardDavController@getCompanyContacts');
			Route::post('/contacts/createCompanyContact', 'CardDavController@createCompanyContact');
			Route::post('/contacts/getContactDetails', 'CardDavController@getContactDetails');
			Route::post('/contacts/editContact', 'CardDavController@editContact');
			Route::post('/contacts/getCompanyContactDetails', 'CardDavController@getCompanyContactDetails');
			Route::post('/contacts/editCompanyContact', 'CardDavController@editCompanyContact');
			Route::post('/contacts/removeContact', 'CardDavController@removeContact');
		});

		Route::middleware('personal_area')->group(function () {
			Route::get('/personal/absence', 'UserController@getPersonalAbsence');
			Route::get('/personal/hoursApproval', 'UserController@getPersonalHoursApproval');
			Route::post('/personal/hoursApproval/getApprovalDetail', 'UserController@getApprovalDetail');
			Route::post('/personal/hoursApproval/editApproval', 'UserController@editApproval');
			Route::get('management/hoursApproval', 'ManagementController@showHoursApproval');
			Route::post('management/hoursApproval/saveApproval', 'ManagementController@saveApproval');
			Route::post('management/hoursApproval/saveReject', 'ManagementController@saveReject');
			Route::post('management/hoursApproval/filter', 'ManagementController@filterApproval');
			Route::get('personal/report', 'PersonalController@getReport');
			Route::post('personal/reportFromYear', 'PersonalController@getReportFromYear');
			Route::post('removeTaskTimer', 'UserController@removeTaskTimer');

			//profile
			Route::get('profile/{id}', 'UserController@profile');
			Route::post('profile/{id}', 'UserController@update_avatar');
			Route::get('profile/{id}/edit', 'UserController@edit_profile_form');
			Route::get('profile/{id}/editDetails', 'UserController@showEditDetails');
			Route::post('profile/{id}/edit', 'UserController@edit_profile');
			Route::post('profile/editDetails/{id}', 'UserController@edit_profile_details');
		});

	});

});

Route::post('/postChangeDefaultPassword', 'ChangeDefaultPasswordController@changePassword')->middleware('auth');
Route::post('/resetPassword', 'ChangeDefaultPasswordController@resetPassword')->middleware('auth');

Auth::routes();
Route::get('/cenas', 'ProjectController@cenas');
Route::get('/timeout', function() {
	return view('timeout');
});
