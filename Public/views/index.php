<?php

    use App\Languages\GetLanguage;
    use App\Models\WebServices\Categories\Tertiary;

include "includes/header.php";
    
?>
<div class="container">
    <div class="general-box">
        <div class="cards-statistics" center>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-dark fa-users"></i>
                    <span><p><?php echo GetLanguage::get('card_statistics_registered') ?></p>18</span>
                </div>
            </div>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-danger fa-pencil-alt"></i>
                    <span><p><?php echo GetLanguage::get('card_statistics_topics') ?></p>18</span>
                </div>
            </div>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-info fa-comment"></i>
                    <span><p><?php echo GetLanguage::get('card_statistics_comments') ?></p>18</span>
                </div>
            </div>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-success fa-eye"></i>
                    <span><p><?php echo GetLanguage::get('card_statistics_views') ?></p>18</span>
                </div>
            </div>
        </div>
        <div class="categories-box">
            <?php if(is_array($primaryCategories)) { foreach($primaryCategories as $categorie) { $sub = $categorie['sub']; ?>
            <div class="general-categorie"<?php echo $categorie['backgroundColor'] ? ' style="background: var(--default-wallpaper), '.$categorie['backgroundColor'].'"' : '' ?>>
                <div class="icon" center><?php echo $categorie['icon'] ?></div>
                <div class="name" center><?php echo $categorie['name'] ?></div>
                <div class="minimize" center><i class="fas fa-minus"></i></div>
            </div>
            <ul class="sub-categories">
                <?php if(is_array($sub)) { foreach($sub as $subcategorie) { $listCategories = (new Tertiary)->show($subcategorie['id']); ?>
                <li class="subcategorie">
                    <div class="icon" center<?php echo $subcategorie['bgIconColor'] ? ' style="background-color: '.$subcategorie['bgIconColor'].'"' : '' ?>><?php echo $subcategorie['icon'] ?></div>
                    <div class="sub-categories-cats">
                        <a class="name" href="/categorie/<?php echo $subcategorie['url'] ?>"><?php echo $subcategorie['name'] ?></a>
                        <ul class="list-categories">
                            <?php if(is_array($listCategories)) { foreach($listCategories as $categorieList) { ?>
                            <a href="<?php echo $categorieList['url'] ?>"><?php echo $categorieList['name'] ?></a>
                            <?php }} else { ?>
                                <ul class="list-categories">
                                    <?php echo GetLanguage::get('categorie_tertiary_not_found') ?>
                                </ul>
                            <?php } ?>
                        </ul>
                        <span class="description"><?php echo $subcategorie['description'] ?></span>
                    </div>
                </li>
                <?php }} else { ?>
                    <li class="subcategorie">
                        <?php echo GetLanguage::get('categorie_secondary_not_found') ?>
                    </li>
                <?php } ?>
            </ul>
            <?php }} else { ?>
                <?php echo GetLanguage::get('categorie_primary_not_found') ?>
            <?php } ?>
        </div>
    </div>
</div>