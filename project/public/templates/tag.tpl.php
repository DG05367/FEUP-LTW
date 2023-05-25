<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
require_once(__DIR__ . '/../database/tag.class.php');
?>

<?php function drawTags(array $tags, PDO $db, int $ticket_id)
{ ?>

  <h2>Tags</h2>

  <section id="tags">
    <?php foreach ($tags as $tag) { ?>
      <article>
        <p>Tag: <?php echo $tag->getTag(); ?></p>
        <form autocomplete="off" action="../actions/action_remove_tag.php" method="post">
          <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">
          <input type="hidden" name="tag" value="<?= $tag->getTag()?>">
          <button class="newticket" type="submit">Remove tag</button>
        </form>
      </article>
    <?php } ?><br>
    <script src='../javascript/autocomplete.js'></script>
    <form autocomplete="off" action="../actions/action_add_tag.php" method="post">
      <input type="text" id="tagsInput" name="tagsInput" autocomplete="off">
      <input type="hidden" name="ticket_id" value="<?= $ticket_id ?>">
      <button class="newticket" type="submit">Add tag</button>  
    </form>
    <script>
    <?php
    $stmt = $db->query('SELECT tag FROM tags');
    $tags = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $tagsJson = json_encode($tags);
    ?>
    var tags = <?php echo $tagsJson; ?>;
    autocomplete(document.getElementById("tagsInput"), tags);
  </script>
  </section>

<?php } ?>
