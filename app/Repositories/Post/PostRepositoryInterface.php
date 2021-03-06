<?php

namespace App\Repositories\Post;

interface PostRepositoryInterface
{
    public function findNewsBySlug($slug);
    public function getNewsWithPagination($startFrom, $recordPerPage);
    public function pagination($startFrom, $recordPerPage, $select_category, $searchText);
    public function findBySlug($slug);
}
