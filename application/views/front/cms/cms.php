<?php if (count($cms_details) > 0) { ?>
    <section id="content" class="cms">
        <div class="page_holder">
            <div class="page_inner">
                <div class="cms_text">
                    <div class="page_head">
                        <h2><?php echo $cms_details[0]['page_title']; ?></h2>
                    </div>
                    <div class="wrapper">
                        <?php echo $cms_details[0]['page_content']; ?>      
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?
}?>