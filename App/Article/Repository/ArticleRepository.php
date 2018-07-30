<?php

namespace App\Article\Repository;

use App\Core\Repository;
use Article;

class ArticleRepository extends Repository
{
    static $prefix = '_xyz_';
    static $table = 'Article';
    static $model = \Article::class;
    static $modelSet = \ArticleCollection::class;
}
