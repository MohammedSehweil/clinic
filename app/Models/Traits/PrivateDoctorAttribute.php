<?php

namespace App\Models\Traits;

use App\Methods\GeneralMethods;

/**
 * Trait PrivateDoctorAttribute.
 */
trait PrivateDoctorAttribute
{
    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.private-doctor.create', ['privatedoctor' => $this->id]) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
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
    public function getApproveButtonAttribute()
    {
        return '<a href="' . route('admin.private-doctor.approve', $this) . '" data-toggle="tooltip" data-placement="top" title="' . 'Approve' . '" class="btn btn-success change_status_button"><i class="fa fa-check"></i></a>';
    }


    /**
     * @return string
     */
    public function getRejectButtonAttribute()
    {
        return '<a href="' . route('admin.private-doctor.reject', $this) . '" data-toggle="tooltip" data-placement="top" title="' . 'Reject' . '" class="btn btn-warning change_status_button"><i class="fa fa-ban"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {

        $state = '';
        if (isAdmin() or isPrivateDoctor()) {
            $edit = $this->edit_button;

            if (isAdmin()) {
                if (!$this->approved) {
                    $state = $this->approve_button;
                } else {
                    $state = $this->reject_button;
                }
            }

        } else {
            $edit = '';
        }


        return '
    	<div class="btn-group" role="group" aria-label="' . __('labels.backend.access.users.user_actions') . '">
		  ' . $edit . '
		  ' . $state . '
		
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
