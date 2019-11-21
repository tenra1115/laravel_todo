<?php

namespace App\Policies;

use App\User;
use App\Folder;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     * @param  App\Folder  $folder
     * @param  App\Policies\FolderPolicy;  $folderpolicy
     * @return void
     */
    // public function __construct()
    // {
    //     $this->authorizeResource(User::class, Folder::class);
    // }

    // public function view(User $user, Folder $folder)
    // {
    //     return $user->id === $folder->user_id;
    // }

    public function render($folder, Exception $exception)
    {
        return parent::render($folder, $exception);
    }
}
