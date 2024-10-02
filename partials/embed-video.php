<?php
$unique_id = uniqid();
$modal = isset($args['modal']) ? $args['modal'] : false; // Check if modal is set
$video_link = isset($args['video_link']) ? $args['video_link'] : ''; // Get the video link
$thumbnail = get_video_thumbnail($video_link); // Get the video thumbnail

$thumbnail_image = isset($args['thumbnail_image']) ? $args['thumbnail_image'] : ''; // Get the custom thumbnail image
$is_youtube = false;
$is_vimeo = false;

$youtube_video_id = get_youtube_video_id($video_link); // Get YouTube video ID
$vimeo_video_id = get_vimeo_video_id($video_link); // Get Vimeo video ID

if ($youtube_video_id) {
    $is_youtube = true; // Set flag for YouTube
    $video_id = $youtube_video_id; // Store the video ID
} elseif ($vimeo_video_id) {
    $is_vimeo = true; // Set flag for Vimeo
    $video_id = $vimeo_video_id; // Store the video ID
}

if ($thumbnail_image) {
    $background_image = $thumbnail_image['url']; // Use custom thumbnail image URL
} else {
    $background_image = $thumbnail; // Use the default thumbnail
}
?>

<?php if ($modal) : ?>
    <a href="<?php echo $video_link; ?>" class="video-thumbnail background-cover" style="background-image: url('<?php echo $background_image; ?>');" data-fancybox>
        <button id="video-button<?php echo $unique_id; ?>" class="video-play">
            <?php echo file_get_contents(get_template_directory() . '/assets/img/play.svg'); ?>
        </button>
    </a>
<?php else : ?>
    <div id="video-container<?php echo $unique_id; ?>" class="video-thumbnail background-cover" style="background-image: url('<?php echo $background_image; ?>');">
        <button id="video-button<?php echo $unique_id; ?>" class="video-play">
            <?php echo file_get_contents(get_template_directory() . '/assets/img/play.svg'); ?>
        </button>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var playButton = document.getElementById("video-button<?php echo $unique_id; ?>");
        var videoContainer = document.getElementById("video-container<?php echo $unique_id; ?>");
        var isYoutube = <?php echo json_encode($is_youtube); ?>; // Check if it's a YouTube video
        var isVimeo = <?php echo json_encode($is_vimeo); ?>; // Check if it's a Vimeo video
        var videoId = "<?php echo $video_id; ?>"; // Get the video ID

        playButton.addEventListener("click", function() {
            var videoWrapper = document.createElement("div");
            videoWrapper.classList.add("ratio", "ratio-16x9");

            var iframe = document.createElement("iframe");

            if (isYoutube) {
                iframe.setAttribute("src", "https://www.youtube.com/embed/" + videoId + "?autoplay=1"); // Set YouTube iframe source
            } else if (isVimeo) {
                iframe.setAttribute("src", "https://player.vimeo.com/video/" + videoId + "?autoplay=1"); // Set Vimeo iframe source
            }

            iframe.setAttribute("allowfullscreen", "");
            iframe.setAttribute("frameborder", "0");
            iframe.setAttribute("allow", "autoplay");

            videoWrapper.appendChild(iframe);

            videoContainer.innerHTML = "";
            videoContainer.appendChild(videoWrapper);
        });
    });
</script>