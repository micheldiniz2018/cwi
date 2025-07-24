<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Retrieve all records from the model.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Retrieve a single user from the model
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new record in the model with the provided data.
     * The password field is hashed before storing.
     *
     * @param array $data The data to create a new record.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->model->create($data);
    }

    /**
     * Update a user's information by their ID.
     *
     * If a password is provided in the data, it will be hashed before updating.
     *
     * @param int $id The ID of the user to update.
     * @param array $data The data to update for the user.
     * @return \Illuminate\Database\Eloquent\Model The updated user model.
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    /**
     * Delete a record by its ID.
     *
     * @param int $id The ID of the record to delete.
     * @return bool|null True if deletion is successful, null otherwise.
     */
    public function delete($id)
    {
        $user = $this->find($id);
        return $user->delete();
    }
}
