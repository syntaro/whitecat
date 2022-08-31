<?php
    wp_enqueue_script('image-resizer','https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js', array(), false, true);
?>
<script type='text/javascript'>
	window.addEventListener( 'resize', function() {
        if (typeof imageMapResize == 'function') {
	        imageMapResize();
            console.log('imageMapResizeがあります');
        } else {
            $('map').imageMapResize();
            console.log('imageMapResizeがありません');
        }
	}, false );
</script>
