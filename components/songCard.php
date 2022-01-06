<?php if (!isset($_SESSION)) {
    Session_start();
} ?>

<div id="SongID_<?php echo $song['songID'] ?>" class="card text-black mx-4">
    <img src="<?php echo  'img/' . $song["album"] . '_Acover.jpeg' ?>" class="card-img-top" alt="Album Cover">
    <div class="card-body">
        <h5 class="card-title text-center"><?php echo $song["title"] ?></h5>
        <p class="card-text"></p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Album: <strong><?php echo $song["album"] ?></strong></li>
            <li class="list-group-item">Likes: <strong><?php echo $song["likes"] ?></strong></li>
        </ul>
        <div class="actions">
            <a onclick="toggleLike(this,`<?php echo $song['songID'] ?>`)" class="btn">
                <!-- Check if you liked this song -->
                <?php
                if ($song["liked"]) {
                    echo '<i class="bi bi-heart-fill likebtn liked" role="img" aria-label="Heart like"></i>';
                } else {
                    echo '<i class="bi bi-heart likebtn" role="img" aria-label="Heart like"></i>';
                }
                ?>
            </a>
            <!-- Add the Source  -->
            <a href="<?php echo $song["src"] ?>" target="_blank" class="btn" role="img" aria-label="play icon"> <i class="bi bi-play playbtn"></i> </a>
        </div>
    </div>
</div>