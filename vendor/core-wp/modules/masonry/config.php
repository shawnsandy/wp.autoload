<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php if (isset($singlemode)): ?>
    <script type="text/javascript">
        jQuery.noConflict(true);

                jQuery('#<?php echo $id ?>').masonry({
                    // options
                    itemSelector : '<?php echo (isset($itemselector) ? $itemselector : '.grid_3') ?>',
                    isResizable : '<?php echo (isset($isresizable) ? $isresiziable : 'true') ?>',
                    //singleMode : <?php echo (isset($singlemode) ? $singlemode : 'true') ?>,//'.item',
                    isAnimated: <?php echo (isset($isanimated) ? $isanimated : 'true') ?>//true
                },
                function() { $(this).css({
                        margin: '0 0 20px 0'
                    });


        })

    </script>
<?php else : ?>
    <script type="text/javascript">
        $(function(){
            $('#<?php echo $id ?>').masonry({
                // options
                itemSelector : '<?php echo (isset($itemselector) ? $itemselector : '.grid_3') ?>',//'.item',
                columnWidth : <?php echo ($cloumnwidth ? $cloumnwidth : '240') ?>,//240,
                isAnimated: <?php echo ($isanimated ? $isanimated : 'true') ?>//true
            });
        });
    </script>
<?php endif ?>
