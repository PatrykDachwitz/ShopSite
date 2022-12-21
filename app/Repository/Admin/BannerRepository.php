<?php
declare(strict_types=1);

namespace App\Repository\Admin;

interface BannerRepository {

    public function getTypes();
    public function create(array $data);
    public function update(array $data, array $images);
    public function addImage(array $image);

}