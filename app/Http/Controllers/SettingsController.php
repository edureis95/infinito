<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getUsersSettings() {
    	$users = \App\User::all();
        $permissions = \App\Permission_Profiles::all();
		return view('settings', array('activeL' => 'utilizadores', 'activeLL' => 'registo', 'users' => $users, 'permissions' => $permissions));
    }

    public function getProjectsExpertise() {
        $expertise = \App\Expertise::orderBy('code')->get();
    	return view('expertiseSettings', array('activeL' => 'projects', 'activeLL' => 'especialidades', 'expertise' => $expertise));
    }

    public function getProjectsPhases() {
        $phases = \App\Phase::orderBy('code')->get();
        return view('phasesSettings', array('activeL' => 'projects', 'activeLL' => 'fases', 'phases' => $phases));
    }

    public function addPhase(Request $r) {
    	$phase = new \App\Phase();
        $phase->code = $r['code'];
        $phase->sigla = $r['sigla'];
    	$phase->name = $r['phase'];
    	$phase->save();
    	return redirect()->back();
    }

    public function addExpertise(Request $r) {
    	$expertise = new \App\Expertise();
        $expertise->code = $r['code'];
        $expertise->sigla = $r['sigla'];
    	$expertise->name = $r['expertise'];
    	$expertise->save();
    	return redirect()->back();
    }

    public function addSubExpertise(Request $r) {
        $expertise = new \App\Expertise();
        $expertise->code = $r['code'];
        $expertise->sigla = $r['sigla'];
        $expertise->name = $r['expertise'];
        $expertise->parent = $r['parent'];
        $expertise->save();
        return redirect()->back();
    }

    public function deleteUser($id) {
        \App\Message::where('user', $id)->delete();
        \App\Chat::where('userID_1', $id)
                 ->orWhere('userID_2', $id)
                 ->delete();

        \App\User::find($id)->delete();
        return redirect()->back();
    }

    public function getExpertiseWithParent() {
        $expertise = \App\Expertise::where('parent', '!=', 0)->orderBy('code', 'desc')->get();
        return $expertise;
    }

    public function removePhase($id) {
        $project_phase = \App\Project_Phase::where('phase_id', $id)->get();
        foreach ($project_phase as $phase) {
            $phase->delete();
        }
        \App\Phase::find($id)->delete();
        return redirect()->back();
    }

    public function removeExpertise($id) {
        $project_expertise = \App\Project_Expertise::where('expertise_id', $id)->get();
        foreach ($project_expertise as $expert) {
            $expert->delete();
        }
        \App\Expertise::find($id)->delete();
        return redirect()->back();
    }

    public function getPermissions() {
        $permission_profiles = \App\Permission_Profiles::all();
        return view('permissions', array('permissionProfiles' => $permission_profiles, 'activeL' => 'utilizadores', 'activeLL' => 'permissoes'));
    }

    public function getProfiles() {
        $permission_profiles = \App\Permission_Profiles::all();
        return view('profileSettings', array('permissionProfiles' => $permission_profiles, 'activeL' => 'utilizadores', 'activeLL' => 'perfis'));
    }

    public function savePermissions(Request $r) {
        $permission_profiles = \App\Permission_Profiles::all();
        foreach ($permission_profiles as $profile) {
            $profile->calendar = $r['calendar' . $profile->id] == 'true'? 1: 0;
            $profile->contacts = $r['contacts' . $profile->id] == 'true'? 1: 0;
            $profile->email = $r['email' . $profile->id] == 'true'? 1: 0;
            $profile->company = $r['company' . $profile->id] == 'true'? 1: 0;
            $profile->projects = $r['projects' . $profile->id] == 'true'? 1: 0;
            $profile->settings = $r['settings' . $profile->id] == 'true'? 1: 0;
            $profile->management = $r['management' . $profile->id] == 'true'? 1: 0;
            $profile->finances = $r['finances' . $profile->id] == 'true'? 1: 0;
            $profile->personalArea = $r['personalArea' . $profile->id] == 'true'? 1: 0;
            $profile->save();
        }
    }

    public function addProfile(Request $r) {
        $profile = new \App\Permission_Profiles();
        $profile->name = $r['profile'];
        $profile->save();
        return redirect()->back();
    }

    public function removeProfile($id) {
        \App\Permission_Profiles::find($id)->delete();
    }

    public function changeUserPermission(Request $r) {
        $user = \App\User::find($r['user_id']);
        $user->profile = $r['permission'];
        $user->save();
    }

    public function showAbsence() {
        $absenceReasons = \App\Absence_Reason::all();
        return view('absenceSettings', array('activeL' => 'empresa', 'activeLL' => 'ausencias', 'absenceReasons' => $absenceReasons));
    }

    public function addAbsenceReason(Request $r) {
        $reason = new \App\Absence_Reason();
        $reason->code = $r['code'];
        $reason->name = $r['reason'];
        $reason->save();
        return redirect()->back();
    }

    public function removeAbsenceReason($id) {
        \App\Absence_Reason::find($id)->delete();
    }

    public function changeExpertiseCode(Request $r) {
        $expertise = \App\Expertise::find($r['id']);
        $expertise->code = $r['code'];
        $expertise->save();
    }

    public function changeExpertiseSigla(Request $r) {
        $expertise = \App\Expertise::find($r['id']);
        $expertise->sigla = $r['sigla'];
        $expertise->save();
    }

    public function changeExpertiseName(Request $r) {
        $expertise = \App\Expertise::find($r['id']);
        $expertise->name = $r['name'];
        $expertise->save();
    }

    public function changePhaseCode(Request $r) {
        $phase = \App\Phase::find($r['id']);
        $phase->code = $r['code'];
        $phase->save();
    }

    public function changePhaseSigla(Request $r) {
        $phase = \App\Phase::find($r['id']);
        $phase->sigla = $r['sigla'];
        $phase->save();
    }

    public function changePhaseName(Request $r) {
        $phase = \App\Phase::find($r['id']);
        $phase->name = $r['name'];
        $phase->save();
    }

    public function getTypes() {
        $types = \App\Project_Type::orderBy('code')->get();
        return view('projectTypeSettings', array('activeL' => 'projects', 'activeLL' => 'tipos', 'types' => $types));
    }

    public function addProjectType(Request $r) {
        $type = new \App\Project_Type();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['type'];
        $type->save();
        return redirect()->back();
    }

    public function deleteProjectType($id) {
        \App\Project_Type::find($id)->delete();
        return redirect()->back();
    }

    public function changeTypeCode(Request $r) {
        $type = \App\Project_Type::find($r['id']);
        $type->code = $r['code'];
        $type->save();
    }

    public function changeTypeSigla(Request $r) {
        $type = \App\Project_Type::find($r['id']);
        $type->sigla = $r['sigla'];
        $type->save();
    }

    public function changeTypeName(Request $r) {
        $type = \App\Project_Type::find($r['id']);
        $type->name = $r['name'];
        $type->save();
    }

    public function getPlanning() {
        $planning = \App\Planning_Type::orderBy('code')->get();
        return view('planningTypesSettings', array('activeL' => 'projects', 'activeLL' => 'planeamento', 'planning' => $planning));
    }

    public function addPlanningType(Request $r) {
        $type = new \App\Planning_Type();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['type'];
        $type->save();
        return redirect()->back();
    }

    public function deletePlanningType($id) {
        \App\Planning_Type::find($id)->delete();
        return redirect()->back();
    }

    public function changePlanningTypeCode(Request $r) {
        $type = \App\Planning_Type::find($r['id']);
        $type->code = $r['code'];
        $type->save();
    }

    public function changePlanningTypeSigla(Request $r) {
        $type = \App\Planning_Type::find($r['id']);
        $type->sigla = $r['sigla'];
        $type->save();
    }

    public function changePlanningTypeName(Request $r) {
        $type = \App\Planning_Type::find($r['id']);
        $type->name = $r['name'];
        $type->save();
    }

    public function getStates() {
        $states = \App\State_Type::orderBy('code')->get();
        return view('stateTypesSettings', array('activeL' => 'projects', 'activeLL' => 'estado', 'states' => $states));
    }

    public function addStateType(Request $r) {
        $type = new \App\State_Type();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['type'];
        $type->save();
        return redirect()->back();
    }

    public function deleteStateType($id) {
        \App\State_Type::find($id)->delete();
        return redirect()->back();
    }

    public function changeStateTypeCode(Request $r) {
        $type = \App\State_Type::find($r['id']);
        $type->code = $r['code'];
        $type->save();
    }

    public function changeStateTypeSigla(Request $r) {
        $type = \App\State_Type::find($r['id']);
        $type->sigla = $r['sigla'];
        $type->save();
    }

    public function changeStateTypeName(Request $r) {
        $type = \App\State_Type::find($r['id']);
        $type->name = $r['name'];
        $type->save();
    }

    public function getDocumentTypes() {
        $documentTypes = \App\Document_Type::orderBy('code')->get();
        return view('documentTypesSettings', array('activeL' => 'projects', 'activeLL' => 'tiposDocumento', 'documentTypes' => $documentTypes));
    }

    public function addDocumentTypes(Request $r) {
        $type = new \App\Document_Type();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['type'];
        $type->save();
        return redirect()->back();
    }

    public function deleteDocumentType($id) {
         \App\Document_Type::find($id)->delete();
        return redirect()->back();
    }

    public function changeDocumentTypeCode(Request $r) {
        $type = \App\Document_Type::find($r['id']);
        $type->code = $r['code'];
        $type->save();
    }

    public function changeDocumentTypeSigla(Request $r) {
        $type = \App\Document_Type::find($r['id']);
        $type->sigla = $r['sigla'];
        $type->save();
    }

    public function changeDocumentTypeName(Request $r) {
        $type = \App\Document_Type::find($r['id']);
        $type->name = $r['name'];
        $type->save();
    }

    public function getDocuments() {
        $types = \App\Document_Type::all();
        $documents= \App\Document_Setting::orderBy('code')->get();
        foreach($documents as $document) {
            $type = \App\Document_Type::find($document->type);
        }
        return view('documentSettings', array('activeL' => 'projects', 'activeLL' => 'documentos', 'documents' => $documents, 'types' => $types));
    }

    public function addDocument(Request $r) {
        $document = new \App\Document_Setting();
        $document->code = $r['code'];
        $document->sigla = $r['sigla'];
        $document->name = $r['type'];
        $document->type = $r['document_type'];
        $document->specialCode = $r['specialCode'];
        $document->save();
        return redirect()->back();
    }

    public function deleteDocument($id) {
         \App\Document_Setting::find($id)->delete();
        return redirect()->back();
    }

    public function changeDocumentCode(Request $r) {
        $type = \App\Document_Setting::find($r['id']);
        $type->code = $r['code'];
        $type->save();
    }

    public function changeDocumentSigla(Request $r) {
        $type = \App\Document_Setting::find($r['id']);
        $type->sigla = $r['sigla'];
        $type->save();
    }

    public function changeDocumentName(Request $r) {
        $type = \App\Document_Setting::find($r['id']);
        $type->name = $r['name'];
        $type->save();
    }

    public function changeDocumentSpecialCode(Request $r) {
        $type = \App\Document_Setting::find($r['id']);
        $type->specialCode = $r['specialCode'];
        $type->save();
    }

    public function changeDocumentType(Request $r) {
        $type = \App\Document_Setting::find($r['id']);
        $type->type = $r['type'];
        $type->save();
    }

    public function getHolidays() {
        $holidays = \App\Holiday::all();

        return view('holidaysSettings', array('holidays' => $holidays, 'activeL' => 'empresa', 'activeLL' => 'férias'));
    }

    public function addHolidayDays(Request $r) {
        $holiday = new \App\Holiday();
        $holiday->year = $r['year'];
        $holiday->required_days = $r['requiredDays'];
        $holiday->extra_days = $r['extraDays'];
        $holiday->save();

        return redirect()->back();
    }

    public function removeHoliday($id) {
        \App\Holiday::find($id)->delete();
    }

    public function getCompanyDays() {
        $companyDays = \App\Company_Day::all();

        return view('companyDaysSettings', array('activeL' => 'empresa', 'activeLL' => 'calendárioEmpresa', 'companyDays' => $companyDays));
    }

    public function addCompanyDay(Request $r) {
        $day = new \App\Company_Day();
        $day->start_date = $r['startDate'];
        if($r['onlyDay'] != true)
            $day->end_date = $r['endDate'];
        $day->reason = $r['reason'];
        $day->description = $r['description'];
        $day->save();

        return redirect()->back();
    }

    public function removeCompanyDay($id) {
        \App\Company_Day::find($id)->delete();
    }

    public function getCompanyDaysByYear(Request $r) {
        $companyDays = \App\Company_Day::whereYear('start_date', '=', $r['year'])->get();

        return $companyDays;
    }

    public function getConstructionTypes() {
        $constructionTypes = \App\Construction_Type::orderBy('code')->get();

        return view('projectConstructionTypesSettings', array('activeL' => 'projects', 'activeLL' => 'tipoConstrução', 'constructionTypes' => $constructionTypes));
    }

    public function addConstructionType(Request $r) {
        $constructionType = new \App\Construction_Type();
        $constructionType->code = $r['code'];
        $constructionType->name = $r['name'];
        $constructionType->save();

        return redirect()->back();
    }

    public function removeConstructionType($id) {
        \App\Construction_Type::find($id)->delete();
    }

    public function getUtilizationTypes() {
        $utilizationTypes = \App\Utilization_Type::orderBy('code')->get();

        return view('projectUtilizationTypeSettings', array('activeL' => 'projects', 'activeLL' => 'tipoUtilização', 'utilizationTypes' => $utilizationTypes));
    }

    public function addUtilizationType(Request $r) {
        $utilizationType = new \App\Utilization_Type();
        $utilizationType->code = $r['code'];
        $utilizationType->name = $r['name'];
        $utilizationType->save();

        return redirect()->back();
    }

    public function removeUtilizationType($id) {
        \App\Utilization_Type::find($id)->delete();
    }

    public function getEventTypes() {
        $types = \App\Project_Event_Type::all();

        return view('eventTypesSettings', array('types' => $types, 'activeL' => 'projects', 'activeLL' => 'tipoAcontecimento'));
    }

    public function addProjectEventType(Request $r) {
        $eventType = new \App\Project_Event_Type();
        $eventType->name = $r['type'];
        $eventType->code = $r['code'];
        $eventType->sigla = $r['sigla'];
        $eventType->save();

        return redirect()->back();
    }

    public function editProjectExpertise(Request $r) {

        foreach($r['obj'] as $key => $value) {
            $expertise = \App\Expertise::find($key);
            $expertise->code = $value[0];
            $expertise->sigla = $value[1];
            $expertise->name = $value[2];
            $expertise->save();
        }

        \App\Expertise::whereNotIn('id', $r['ids'])->delete();
    }

    public function editProjectPhases(Request $r) {
        foreach($r['obj'] as $key => $value) {
            $phase = \App\Phase::find($key);
            $phase->code = $value[0];
            $phase->sigla = $value[1];
            $phase->name = $value[2];
            $phase->save();
        }

        \App\Phase::whereNotIn('id', $r['ids'])->delete();
    }

    public function editProjectTypes(Request $r) {
        foreach($r['obj'] as $key => $value) {
            $type = \App\Project_Type::find($key);
            $type->code = $value[0];
            $type->sigla = $value[1];
            $type->name = $value[2];
            $type->save();
        }

        \App\Project_Type::whereNotIn('id', $r['ids'])->delete();
    }

    public function editProjectConstructionTypes(Request $r) {
        foreach($r['obj'] as $key => $value) {
            $type = \App\Construction_Type::find($key);
            $type->code = $value[0];
            $type->name = $value[1];
            $type->save();
        }

        \App\Construction_Type::whereNotIn('id', $r['ids'])->delete();
    }

    public function editProjectUtilizationTypes(Request $r) {
        foreach($r['obj'] as $key => $value) {
            $type = \App\Utilization_Type::find($key);
            $type->code = $value[0];
            $type->name = $value[1];
            $type->save();
        }

        \App\Utilization_Type::whereNotIn('id', $r['ids'])->delete();
    }

    public function getProjectUserFunction() {
        $functions = \App\Project_User_Function::orderBy('code')->get();

        return view('projectUserFunctionSettings', array('activeL' => 'projects', 'activeLL' => 'tipoFunção', 'functions' => $functions));
    }

    public function addProjectUserFunction(Request $r) {
        $function = new \App\Project_User_Function();
        $function->code = $r['code'];
        $function->sigla = $r['sigla'];
        $function->name = $r['name'];
        $function->save();

        return redirect()->back();
    }

    public function getProjectGeneralUserFunction() {
        $functions = \App\Project_General_User_Function::all();

        return view('projectGeneralUserFunctionSettings', array('activeL' => 'projects', 'activeLL' => 'funçãoGeral', 'functions' => $functions));
    }

    public function addProjectGeneralUserFunction(Request $r) {
        $function = new \App\Project_General_User_Function();
        $function->code = $r['code'];
        $function->sigla = $r['sigla'];
        $function->name = $r['name'];
        $function->save();

        return redirect()->back();
    }

    public function getGeneralExpertise() {

        $expertise = \App\General_Expertise::all();

        return view ('generalExpertiseSettings', array('activeL' => 'projects', 'activeLL' => 'especialidadesGerais', 'expertise' => $expertise));
    }

    public function addGeneralExpertise(Request $r) {
        $expertise = new \App\General_Expertise();
        $expertise->code = $r['code'];
        $expertise->sigla = $r['sigla'];
        $expertise->name = $r['name'];
        $expertise->save();

        return redirect()->back();
    }

    public function getContactTypes() {

        $types = \App\Contact_Type::all();

        return view('contact_type_settings', array('activeL' => 'contactos', 'activeLL' => 'tipos', 'types' => $types));
    }

    public function addContactType(Request $r) {
        $type = new \App\Contact_Type();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['name'];
        $type->save();

        return redirect()->back();
    }

    public function getContactSources() {

        $sources = \App\Contact_Source::all();

        return view('contact_sources_settings', array('activeL' => 'contactos', 'activeLL' => 'origem', 'sources' => $sources));
    }

    public function addContactSource(Request $r) {
        $source = new \App\Contact_Source();
        $source->code = $r['code'];
        $source->sigla = $r['sigla'];
        $source->name = $r['name'];
        $source->save();

        return redirect()->back();
    }

    public function getIVASettings() {
        $iva = \App\Iva::orderBy('percentage')->get();

        return view('ivaSettings', array('iva' => $iva, 'activeL' => 'comercial', 'activeLL' => 'iva'));
    }

    public function addIva(Request $r) {
        $iva = new \App\Iva();
        $iva->percentage = $r['percentage'];
        $iva->save();

        return redirect()->back();
    }

    public function getHourlyRate() {
        $hourlyRate = \App\Commercial_Hourly_Rate::orderBy('value')->get();

        return view('hourlyRateSettings', array('activeL' => 'comercial', 'activeLL' => 'preçoHoras', 'hourlyRate' => $hourlyRate)); 
    }

    public function addHourlyRate(Request $r) {
        $hourlyRate = new \App\Commercial_Hourly_Rate();
        $hourlyRate->value = $r['value'];
        $hourlyRate->save();

        return redirect()->back();
    }

    public function getCompanyContactTypes() {
        $types = \App\Company_Contact_Type::all();

        return view('company_contact_type_settings', array('activeL' => 'contactos', 'activeLL' => 'tiposEmpresa', 'types' => $types));
    }

    public function addCompanyContactType(Request $r) {
        $type = new \App\Company_Contact_Type();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['name'];
        $type->save();

        return redirect()->back();
    }

    public function getCompanyContactFields() {
        $types = \App\Company_Contact_Field::all();

        return view('company_contact_field_settings', array('activeL' => 'contactos', 'activeLL' => 'áreas', 'types' => $types));
    }

    public function addCompanyContactField(Request $r) {
        $type = new \App\Company_Contact_Field();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['name'];
        $type->save();

        return redirect()->back();
    }

    public function getCompanyContactDimensions() {
        $types = \App\Company_Contact_Dimension::all();

        return view('company_contact_dimension_settings', array('activeL' => 'contactos', 'activeLL' => 'dimensões', 'types' => $types));
    }

    public function addCompanyContactDimension(Request $r) {
        $type = new \App\Company_Contact_Dimension();
        $type->code = $r['code'];
        $type->sigla = $r['sigla'];
        $type->name = $r['name'];
        $type->save();

        return redirect()->back();
    }

}
