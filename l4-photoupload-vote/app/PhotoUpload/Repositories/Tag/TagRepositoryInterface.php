<?php namespace PhotoUpload\Repositories\Tag;

interface TagRepositoryInterface
{
    /**
     * Get an array of key-value (id => name) pairs of all tags.
     *
     * @return array
     */
    public function listAll();

    /**
     * Find all tags with the associated number of images.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithImageCount();

    /**
     * Create a new tag in the database.
     *
     * @param  array $data
     * @return \PhotoUpload\Models\Tag
     */
    public function store(array $data);

    /**
     * Update the specified tag in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \PhotoUpload\Models\Tag
     */
    public function update($id, array $data);

    /**
     * Delete the specified tag from the database.
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id);
}
