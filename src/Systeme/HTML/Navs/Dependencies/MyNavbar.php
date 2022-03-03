<?php use Systeme\HTML\Users\Look; ?>

<div class="blur"></div>

<div class="box-myInfos">
    <div class="close" onclick="myNavbar()"></div>

    <div class="infos divided-2">
        <div class="left">
            <div class="standalone">
                <div class="avatar">
                    <a href="<?= $myDatas->link; ?>">
                        <img src="<?= Look::load($myDatas->look, ['HEADDIRECTION' => 'S', 'FACE' => 'smile', 'ACTION' => 'wave']); ?>" />
                    </a>
                </div>
                <div class="about">
                    <p>
                        <span>pseudo: </span>
                        <?= $myDatas->username; ?>
                    </p>
                    <p>
                        <span>motto: </span>
                        <?= $myDatas->motto; ?>
                    </p>
                    <div class="divided-2-forced">
                        <p class="hover"><?= $myDatas->sub; ?></p>
                        <p><?= $myDatas->coins; ?></p>
                    </div>
                </div>
            </div>
            <?php if ($alerts): ?>
            <div class="alertes">
                <p class="text">
                    <?= $alerts->message; ?>
                    <span><?= $alerts->createAt; ?></span>
                </p>
                <p class="icon"><?= $alerts->author; ?></p>
            </div>
            <?php endif; ?>
            <div class="palmares divided-4-forced">
                <div>PALMARES</div>
                <div>PALMARES</div>
                <div>PALMARES</div>
                <div>PALMARES</div>
            </div>
        </div>
        <div class="right">
            <div class="notifications buttons-container">
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
                <a href="#" class="hover"><div>
                    <p>IMG</p>
                    <p>UNE NOTIFICATION</p>
                    <p>date</p>
                </div></a>
            </div>
            <div class="quests-progress divided-4-forced">
                <div>QUETE</div>
                <div>QUETE</div>
                <div>QUETE</div>
                <div>QUETE</div>
            </div>
        </div>
    </div>
</div>