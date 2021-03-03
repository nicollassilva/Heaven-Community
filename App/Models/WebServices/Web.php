<?php

namespace App\Models\WebServices;

use App\Boot\ForumConfiguration;
use App\Core\Utils\BaseApiModel;

class Web extends BaseApiModel {
    
    function __construct()
    {
        parent::__construct('heaven_config', 'id');
    }

    public function information(String $information)
    {
        $info = $this
            ->find(1)
            ->only([$information])
            ->execute();

        return isset($info[$information]) ? $info[$information] : false;
    }

    public static function generateViewPaginate(Int $total, Int $atual, Int $limit)
    {
        $pageComplete = explode('/', $_SERVER['REQUEST_URI']);
        $page = function(Int $pageId) use ($pageComplete) {
            return ForumConfiguration::getRouter('Topic.ShowPagination', [
                'id' => $pageComplete[2],
                'handle' => $pageComplete[3],
                'paginate' => $pageId
            ]);
        };

        $start = '<nav>
            <ul class="pagination justify-content-end">
            <li class="page-item'.($atual <= 1 ? ' disabled' : '').'">
                <a class="page-link" href="'.$page(1).'"'.($atual <= 1 ? ' tabindex="-1"' : '').'><i class="fas fa-chevron-left"></i></a>
            </li>';
        
        $totalPages = ceil($total / $limit);
        $body = '';
        for($i = 1; $i <= $totalPages; $i++) {
            $body .= '<li class="page-item'.($i == $atual ? ' active' : '').'"><a class="page-link" href="'.$page($i).'">'.$i.'</a></li>';
        }

        $end = '<li class="page-item'.($atual == $totalPages ? ' disabled' : '').'">
                    <a class="page-link" href="'.$page($totalPages).'"'.($atual == $totalPages ? ' tabindex="-1"' : '').'><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>';

        return $start . $body . $end;
    }
}