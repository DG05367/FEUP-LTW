<?php

declare(strict_types=1);
require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

function drawComments(array $comments)
{ ?>
  <h2>Comments</h2>

  <section id="comments">
    <?php foreach ($comments as $comment) { ?>
      <article>
        <p>Comment: <?php echo $comment->getComment(); ?></p>
        <p>Posted on: <?php echo $comment->getCreatedAt(); ?></p>
      </article>
    <?php } ?>
  </section>
<?php }

function drawCreateNewComment(int $ticketId)
{ ?>
  <form action="../actions/action_create_comment.php?ticket_id=<?php echo $ticketId; ?>" method="post" class="comment">
    <input type="text" name="comment" placeholder="Comment">
    <button type="submit">Post new comment</button>
  </form>
<?php }
?>
