<?php

namespace App\Models\Traits;
use App\Methods\GeneralMethods;

/**
 * Trait DoctorAttribute.
 */
trait DoctorAttribute
{
    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.doctor.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.doctor.destroy', $this) . '"
			 data-method="delete"
			 data-trans-button-cancel="' . __('buttons.general.cancel') . '"
			 data-trans-button-confirm="' . __('buttons.general.crud.delete') . '"
			 data-trans-title="' . __('strings.backend.general.are_you_sure') . '"
			 class="btn btn-danger"><i class="fas fa-trash" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.delete') . '"></i></a> ';
    }

    /**
     * @return string
     */
    public function getShowButtonAttribute()
    {
        return '<a href="' . route('admin.doctor.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {


        $doctorIds = app(GeneralMethods::class)->getClinicOwnerDoctorsIds();

        if (isCurrentUser($this->id) or isAdmin() or in_array($this->id, $doctorIds)) {
            $edit = $this->edit_button;
            $delete = $this->delete_button;
        } else {
            $edit = '';
            $delete = '';
        }


        return '
    	<div class="btn-group" role="group" aria-label="' . __('labels.backend.access.users.user_actions') . '">
		  ' . $this->show_button . '
		  ' . $edit . '
          ' . $delete . '
		
		</div>';
    }


    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->last_name
            ? $this->first_name . ' ' . $this->last_name
            : $this->first_name;
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->full_name;
    }


}
