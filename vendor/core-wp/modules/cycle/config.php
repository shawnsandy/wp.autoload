<script type="text/javascript">

jQuery.noConflict();
(function($) {
$('#<?php echo (isset($id) ? $id : 'cycle') ?>').cycle({
    fx:    '<?php echo (isset($fx) ? $fx : 'scrollLeft') ?>',//name of transition effect (or comma separated names, ex: 'fade,scrollUp,shuffle')
    speed:  '<?php echo (isset($speed) ? $speed : 'fast') ?>', // speed of the transition (any valid fx speed value)
    timeout: <?php echo (isset($timeout) ? $timeout : '5000') ?>, // milliseconds between slide transitions (0 to disable auto advance)
    next:   '<?php echo (isset($next) ? $next : '#next') ?>', // element, jQuery object, or jQuery selector string for the element to use as event trigger for next slide
    prev:   '<?php echo (isset($prev) ? $prev : '#prev') ?>'

});
})(jQuery);
</script>
