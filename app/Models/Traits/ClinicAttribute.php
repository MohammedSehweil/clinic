<?php

namespace App\Models\Traits;

/**
 * Trait ClinicAttribute.
 */
trait ClinicAttribute
{
    /**
     * @return string
     */
    public function getEditButtonAttribute()
    {
        return '<a href="' . route('admin.clinic.edit', $this) . '" class="btn btn-primary"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.edit') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute()
    {
        return '<a href="' . route('admin.clinic.destroy', $this) . '"
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
        return '<a href="' . route('admin.clinic.show', $this) . '" data-toggle="tooltip" data-placement="top" title="' . __('buttons.general.crud.view') . '" class="btn btn-info"><i class="fas fa-eye"></i></a>';
    }


    /**
     * @return string
     */
    public function getApproveButtonAttribute()
    {
        return '<a href="' . route('admin.clinic.approve', $this) . '" data-toggle="tooltip" data-placement="top" title="' . 'Approve' . '" class="btn btn-success change_status_button"><i class="fa fa-check"></i></a>';
    }


    /**
     * @return string
     */
    public function getRejectButtonAttribute()
    {
        return '<a href="' . route('admin.clinic.reject', $this) . '" data-toggle="tooltip" data-placement="top" title="' . 'Reject' . '" class="btn btn-warning change_status_button"><i class="fa fa-ban"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        $edit = '';
        $delete = '';
        $state = '';
        $user = \Auth::user();
        if (isAdmin() || $user->id == $this->owner_id) {
            $edit = $this->edit_button;
            $delete = $this->delete_button;
            if (isAdmin()) {
                if (!$this->approved) {
                    $state = $this->approve_button;
                } else {
                    $state = $this->reject_button;
                }
            }
        }
        return '<div class="btn-group btn-group-sm" role="group" aria-label="'.__('labels.backend.access.users.user_actions').'">
            '.$this->show_button.
            $edit.
            $delete.
            $state.
            '</div>';
    }
}
