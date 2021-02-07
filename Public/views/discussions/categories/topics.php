<?php

use App\Languages\GetLanguage;
use App\Boot\ForumConfiguration;
use App\Models\WebServices\Categories\Tertiary;

$heavenTitle = 'Tópicos: ' . $quaternary['name'];
$heavenBreadcrumb = ['Fórum', $tertiary['name'], $quaternary['name']];
include dirname(__DIR__, 2) . "/includes/header.php";

$topics = false;

?>
<div class="container">
    <div class="general-box">
        <div class="categories-box w-100">
            <div class="general-categorie-info">
                <span><?php echo $secondary['name'] . '<i class="fas fa-angle-double-right mx-2"></i> Tópicos sobre <b class="text-primary">' . $quaternary['name'] ?></b></span>
                <p><?php echo $quaternary['description'] ?></p>
                <hr class="my-0">
                <?php if(isset($_SESSION['userHeavenLogged'])) { ?>
                <a href="<?php echo ForumConfiguration::getRouter('Topic.Create') ?>" class="btn btn-sm mt-3 btn-success"><i class="fas fa-plus mr-2"></i><?php echo GetLanguage::get('text_post_new_topic') ?></a>
                <?php } ?>
                <button class="btn btn-sm mt-3 btn-dark ml-2"><i class="fas fa-list-ol mr-2"></i><?php echo GetLanguage::get('last_topics_comments') ?></button>
            </div>
            <div class="general-categorie">
                <div class="name" center><i class="fas fa-angle-double-right mx-2"></i><?php echo GetLanguage::get('topics_title') ?></div>
            </div>
            <nav aria-label="Page navigation example" class="float-right">
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
            <ul class="sub-categories">
                <?php if (is_array($topics)) {
                    foreach ($quaternary as $categorie) { ?>
                        <li class="subcategorie">
                            <div class="icon" style="background-color: var(--second-strong-color)" center><i class="fas fa-comment"></i></div>
                            <div class="sub-categories-cats">
                                <a class="name" href="<?php echo $secondary['id'] ?>/<?php echo $tertiary['url'] ?>/<?php echo $categorie['url'] ?>"><?php echo $categorie['name'] ?></a>
                                <div class="statistics">
                                    <div class="topics" data-toggle="tooltip" title="Total de Tópicos" center><i class="fas fa-pencil-alt"></i><?php echo random_int(0, 1000000) ?></div>
                                    <div class="views" data-toggle="tooltip" title="Total de Visualizações" center><i class="fas fa-eye"></i><?php echo random_int(0, 1000000) ?></div>
                                </div>
                                <span class="description"><?php echo $categorie['description'] ?></span>
                            </div>
                            <div class="last-post">
                                <div class="photo" style="background-image: url('https://i.pinimg.com/originals/8b/da/ca/8bdaca81d5ddbaeb92b61d6b5787d866.jpg')"></div>
                                <div class="title text-truncate"><a href="/topic/">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur quisquam, accusamus quae quam.</a></div>
                                <div class="time">Hoje ás 13:45</div>
                                <div class="owner text-truncate"><i class="fas fa-user text-secondary mr-1"></i><a href="/user/">iNicollas</a></div>
                            </div>
                        </li>
                <?php }
                } ?>
            </ul>
        </div>
        <nav aria-label="Page navigation example" class="float-right">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    </div>
</div>