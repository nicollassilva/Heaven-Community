<?php

use App\Languages\GetLanguage;
use App\Boot\ForumConfiguration;
use App\Models\WebServices\Categories\Tertiary;

$heavenTitle = 'Meus pedidos de Amizade';
$heavenBreadcrumb = ['Fórum', $primary['name'], $secondary['name']];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box">
        <div class="categories-box">
            <div class="general-categorie" <?php echo $secondary['bgIconColor'] ? ' style="background: var(--default-wallpaper), ' . $secondary['bgIconColor'] . '"' : '' ?>>
                <div class="icon" center><?php echo $secondary['icon'] ?></div>
                <div class="name" center><?php echo $secondary['name'] ?></div>
                <div class="minimize" center><i class="fas fa-minus"></i></div>
            </div>
            <ul class="sub-categories">
                <?php if (is_array($tertiary)) {
                    foreach ($tertiary as $subcategorie) {
                        $listCategories = $quaternary((int) $subcategorie['id']); ?>
                        <li class="subcategorie">
                            <div class="icon" center<?php echo $secondary['bgIconColor'] ? ' style="background-color: ' . $secondary['bgIconColor'] . '"' : '' ?>><?php echo $subcategorie['icon'] ?></div>
                            <div class="sub-categories-cats">
                                <a class="name" href="/categorie/<?php echo $secondary['url'] ?>"><?php echo $subcategorie['name'] ?></a>
                                <ul class="list-categories">
                                    <?php if (is_array($listCategories)) {
                                        foreach ($listCategories as $categorieList) { ?>
                                            <a href="<?php echo $secondary['url'] . '/' . $categorieList['url'] ?>">- <?php echo $categorieList['name'] ?></a>
                                    <?php }
                                    } ?>
                                </ul>
                                <div class="statistics">
                                    <div class="topics" data-toggle="tooltip" title="Total de Tópicos" center><i class="fas fa-pencil-alt"></i><?php echo random_int(0, 1000000) ?></div>
                                    <div class="views" data-toggle="tooltip" title="Total de Visualizações" center><i class="fas fa-eye"></i><?php echo random_int(0, 1000000) ?></div>
                                </div>
                                <span class="description"><?php echo $subcategorie['description'] ?></span>
                            </div>
                            <div class="last-post">
                                <div class="photo" style="background-image: url('https://i.pinimg.com/originals/8b/da/ca/8bdaca81d5ddbaeb92b61d6b5787d866.jpg')"></div>
                                <div class="title text-truncate"><a href="/topic/">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur quisquam, accusamus quae quam.</a></div>
                                <div class="time">Hoje ás 13:45</div>
                                <div class="owner text-truncate"><i class="fas fa-user text-secondary mr-1"></i><a href="/user/">iNicollas</a></div>
                            </div>
                        </li>
                    <?php }
                } else { ?>
                    <li class="subcategorie">
                        <?php echo GetLanguage::get('categorie_secondary_not_found') ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="general-right-column">
            <div class="last-activities">
                <div class="general-title" center>
                    <?php echo GetLanguage::get('last_activities_title') ?>
                </div>
                <ul class="activies">
                    <?php for ($i = 0; $i < 15; $i++) { ?>
                        <li>
                            <div class="photo" style="background-image: url('https://i.pinimg.com/originals/8b/da/ca/8bdaca81d5ddbaeb92b61d6b5787d866.jpg')"></div>
                            <div class="title text-truncate"><a href="/topic/">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Consequatur quisquam, accusamus quae quam.</a></div>
                            <div class="time">Hoje ás 13:45</div>
                            <div class="owner text-truncate"><i class="fas fa-user text-secondary mr-1"></i><a href="/user/">iNicollas</a></div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="general-title" center>
                <?php echo GetLanguage::get('our_partners') ?>
            </div>
            <div class="partners">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image: url('https://i.pinimg.com/originals/de/f6/96/def69643889ee29e232637646e839064.jpg')"></div>
                        <div class="swiper-slide" style="background-image: url('https://i2.wp.com/marketingcomcafe.com.br/wp-content/uploads/2017/12/banco-imagens-gratis.png')"></div>
                        <div class="swiper-slide" style="background-image: url('https://i0.wp.com/gamelogia.com.br/wp-content/uploads/2016/11/gamer.jpg?resize=1280%2C640&ssl=1')"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>